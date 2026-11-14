<?php

namespace Tests\Feature;

use App\Events\ComandoActualizado;
use App\Events\EstadoActuadorActualizado;
use App\Events\LecturaRegistrada;
use App\Events\PresenciaModuloActualizada;
use App\Models\Actuador;
use App\Models\Modulo;
use App\Models\Sensor;
use App\Models\User;
use App\Services\ProcesadorAckIot;
use App\Services\ProcesadorTelemetriaIot;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Broadcast;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;

class RealtimeIotTest extends TestCase
{
    use RefreshDatabase;

    public function test_telemetry_persists_source_and_dispatches_module_event(): void
    {
        Event::fake([LecturaRegistrada::class]);
        $modulo = Modulo::create(['codigo' => 'MOD-WS', 'uid' => 'ESP-WS', 'habilitado' => true]);
        Sensor::create([
            'modulo_id' => $modulo->id,
            'codigo' => 'S_TEMP',
            'nombre' => 'Temperatura',
            'tipo' => 'temperatura',
            'unidad' => '°C',
            'activo' => true,
        ]);

        $result = app(ProcesadorTelemetriaIot::class)->procesar($modulo, [[
            'codigo' => 'S_TEMP',
            'valor' => 21.5,
            'medido_en' => now()->toIso8601String(),
        ]], 'mqtt');

        $this->assertSame(1, $result['guardadas']);
        $raw = json_decode(DB::table('lecturas')->value('raw'), true);
        $this->assertSame('mqtt', $raw['canal']);

        Event::assertDispatched(LecturaRegistrada::class, function (LecturaRegistrada $event) use ($modulo) {
            $channel = $event->broadcastOn()[0];

            return $event->moduloId === $modulo->id
                && $event->lectura['sensor_codigo'] === 'S_TEMP'
                && $event->lectura['canal'] === 'mqtt'
                && $channel instanceof PrivateChannel
                && $channel->name === 'private-modulos.'.$modulo->id;
        });
    }

    public function test_ack_dispatches_command_and_reported_actuator_events(): void
    {
        Event::fake([ComandoActualizado::class, EstadoActuadorActualizado::class]);
        $modulo = Modulo::create(['codigo' => 'MOD-ACK', 'uid' => 'ESP-ACK', 'habilitado' => true]);
        $actuador = Actuador::create([
            'modulo_id' => $modulo->id,
            'codigo' => 'D_FAN',
            'nombre' => 'Ventilador',
            'tipo' => 'rele',
            'activo' => true,
            'estado_deseado' => ['on' => true],
            'estado_reportado' => ['on' => false],
        ]);
        DB::table('comandos_iot')->insert([
            'modulo_id' => $modulo->id,
            'actuador_id' => $actuador->id,
            'tipo' => 'set_estado',
            'payload' => json_encode(['on' => true]),
            'estado' => 'enviado',
            'nonce' => 'ws-ack',
            'intentos' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $result = app(ProcesadorAckIot::class)->procesar($modulo, 'ws-ack', true, null, [[
            'actuador' => 'D_FAN',
            'estado' => ['on' => true],
        ]]);

        $this->assertTrue($result['ok']);
        Event::assertDispatched(ComandoActualizado::class, fn ($event) => $event->comando['estado'] === 'confirmado');
        Event::assertDispatched(EstadoActuadorActualizado::class, fn ($event) => $event->actuador['estado_reportado'] === ['on' => true]);
    }

    public function test_state_snapshot_is_private_and_returns_current_values(): void
    {
        $modulo = Modulo::create([
            'codigo' => 'MOD-SNAPSHOT',
            'uid' => 'ESP-SNAPSHOT',
            'habilitado' => true,
            'ultimo_contacto' => now(),
        ]);
        $sensor = Sensor::create([
            'modulo_id' => $modulo->id,
            'codigo' => 'S_TEMP',
            'nombre' => 'Temperatura',
            'tipo' => 'temperatura',
            'unidad' => '°C',
            'activo' => true,
            'valor_actual' => 22.25,
            'valor_actual_en' => now(),
        ]);

        $this->getJson(route('panel.modulos.estado', $modulo))->assertUnauthorized();

        $lector = User::factory()->create(['rol' => 'lector']);
        $this->actingAs($lector)->getJson(route('panel.modulos.estado', $modulo))->assertForbidden();

        $operador = User::factory()->create(['rol' => 'operador']);
        $this->actingAs($operador)
            ->getJson(route('panel.modulos.estado', $modulo))
            ->assertOk()
            ->assertJsonPath('modulo.online', true)
            ->assertJsonPath('sensores.0.id', $sensor->id)
            ->assertJsonPath('sensores.0.valor', 22.25);
    }

    public function test_private_module_channel_authorizes_only_operational_roles(): void
    {
        config([
            'broadcasting.default' => 'reverb',
            'broadcasting.connections.reverb.key' => 'test-key',
            'broadcasting.connections.reverb.secret' => 'test-secret',
            'broadcasting.connections.reverb.app_id' => 'test-app',
        ]);
        Broadcast::forgetDrivers();
        require base_path('routes/channels.php');

        $modulo = Modulo::create(['codigo' => 'MOD-CHANNEL', 'uid' => 'ESP-CHANNEL', 'habilitado' => true]);
        $payload = [
            'socket_id' => '123.456',
            'channel_name' => 'private-modulos.'.$modulo->id,
        ];

        $operador = User::factory()->create(['rol' => 'operador']);
        $this->actingAs($operador)
            ->postJson('/broadcasting/auth', $payload)
            ->assertOk()
            ->assertJsonStructure(['auth']);

        $lector = User::factory()->create(['rol' => 'lector']);
        $this->actingAs($lector)
            ->postJson('/broadcasting/auth', $payload)
            ->assertForbidden();
    }

    public function test_mqtt_status_dispatches_presence_event(): void
    {
        Event::fake([PresenciaModuloActualizada::class]);
        $modulo = Modulo::create(['codigo' => 'MOD-PRESENCE', 'uid' => 'ESP-PRESENCE', 'habilitado' => true]);
        config(['mqtt.webhook_secret' => 'presence-secret']);

        $this->postJson('/api/mqtt/v1/webhook', [
            'topic' => 'tesis/MOD-PRESENCE/status',
            'payload' => ['status' => 'offline'],
        ], ['X-MECACUY-MQTT-SECRET' => 'presence-secret'])
            ->assertOk();

        Event::assertDispatched(PresenciaModuloActualizada::class, fn ($event) => $event->moduloId === $modulo->id
            && $event->presencia['online'] === false
            && $event->presencia['canal'] === 'mqtt');
    }
}
