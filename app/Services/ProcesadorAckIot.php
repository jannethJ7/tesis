<?php

namespace App\Services;

use App\Events\ComandoActualizado;
use App\Events\EstadoActuadorActualizado;
use Illuminate\Support\Facades\DB;

class ProcesadorAckIot
{
    public function procesar(object $modulo, string $nonce, bool $ok, ?string $error = null, array $reportados = []): array
    {
        $resultado = DB::transaction(function () use ($modulo, $nonce, $ok, $error, $reportados) {
            $actuadoresActualizados = [];

            // Serializa los ACK del mismo comando entre REST y MQTT.
            $comando = DB::table('comandos_iot')
                ->where('modulo_id', $modulo->id)
                ->where('nonce', $nonce)
                ->lockForUpdate()
                ->first();

            $resultadoAck = app(GestorComandosIot::class)->registrarAck(
                (int) $modulo->id,
                $nonce,
                $ok,
                $error
            );

            if (! ($resultadoAck['ok'] ?? false)) {
                return ['ok' => false, 'ack' => $resultadoAck];
            }

            if (! empty($resultadoAck['duplicado'])) {
                return ['ok' => true, 'ack' => $resultadoAck, 'alerta_comando' => null];
            }

            if (! empty($reportados)) {
                foreach ($reportados as $rep) {
                    $codigo = $rep['actuador'] ?? null;
                    $estado = $rep['estado'] ?? null;

                    if (! $codigo || ! is_array($estado)) {
                        continue;
                    }

                    $act = DB::table('actuadores')
                        ->where('modulo_id', $modulo->id)
                        ->where('codigo', $codigo)
                        ->first();

                    if (! $act || ($comando->actuador_id && (int) $act->id !== (int) $comando->actuador_id)) {
                        continue;
                    }

                    // Un ACK antiguo no debe revertir un reporte ya confirmado más reciente.
                    if (DB::table('comandos_iot')->where('modulo_id', $modulo->id)
                        ->where('actuador_id', $act->id)->where('id', '>', $comando->id)
                        ->where('estado', 'confirmado')->exists()) {
                        continue;
                    }

                    $estadoJson = json_encode($estado);
                    $yaEraMismoEstado = $act->estado_reportado === $estadoJson;

                    DB::table('actuadores')->where('id', $act->id)->update([
                        'estado_reportado' => $estadoJson,
                        'cambiado_en' => now(),
                        'updated_at' => now(),
                    ]);

                    $actuadoresActualizados[] = [
                        'id' => (int) $act->id,
                        'codigo' => (string) $act->codigo,
                        'estado_deseado' => $act->estado_deseado
                            ? json_decode($act->estado_deseado, true)
                            : null,
                        'estado_reportado' => $estado,
                        'cambiado_en' => now()->toIso8601String(),
                        'nonce' => $nonce,
                    ];

                    // El mismo ACK puede llegar por MQTT y luego por REST durante una
                    // transición. No duplicamos la actuación si el estado no cambió.
                    if (! $yaEraMismoEstado) {
                        DB::table('actuaciones')->insert([
                            'modulo_id' => $modulo->id,
                            'actuador_id' => $act->id,
                            'origen' => 'sistema',
                            'estado_anterior' => $act->estado_reportado,
                            'estado_nuevo' => $estadoJson,
                            'motivo' => json_encode([
                                'fuente' => 'ack',
                                'nonce' => $nonce,
                                'ok' => $ok,
                            ]),
                            'ejecutado_en' => now(),
                            'created_at' => now(),
                            'updated_at' => now(),
                        ]);
                    }
                }
            }

            return [
                'ok' => true,
                'ack' => $resultadoAck,
                'alerta_comando' => $resultadoAck['alerta_comando'] ?? null,
                'actuadores_actualizados' => $actuadoresActualizados,
            ];
        });

        if (($resultado['ok'] ?? false) && empty($resultado['ack']['duplicado'])) {
            $comando = DB::table('comandos_iot')
                ->where('modulo_id', $modulo->id)
                ->where('nonce', $nonce)
                ->first();

            if ($comando) {
                ComandoActualizado::dispatch((int) $modulo->id, [
                    'id' => (int) $comando->id,
                    'actuador_id' => $comando->actuador_id ? (int) $comando->actuador_id : null,
                    'nonce' => (string) $comando->nonce,
                    'estado' => (string) $comando->estado,
                    'intentos' => (int) $comando->intentos,
                    'confirmado_en' => $comando->confirmado_en,
                    'ultimo_error' => $comando->ultimo_error,
                ]);
            }

            foreach ($resultado['actuadores_actualizados'] ?? [] as $actuador) {
                EstadoActuadorActualizado::dispatch((int) $modulo->id, $actuador);
            }
        }

        return $resultado;
    }
}
