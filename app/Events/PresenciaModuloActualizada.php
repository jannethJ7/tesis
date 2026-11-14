<?php

namespace App\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class PresenciaModuloActualizada implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct(
        public readonly int $moduloId,
        public readonly array $presencia,
    ) {}

    public function broadcastOn(): array
    {
        return [new PrivateChannel('modulos.'.$this->moduloId)];
    }

    public function broadcastAs(): string
    {
        return 'modulo.presencia';
    }

    public function broadcastWith(): array
    {
        return [
            'modulo_id' => $this->moduloId,
            'presencia' => $this->presencia,
        ];
    }
}
