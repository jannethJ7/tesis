<?php

use App\Models\Modulo;
use App\Models\User;
use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('modulos.{moduloId}', function (User $user, int $moduloId): bool {
    return in_array($user->rol, ['admin', 'operador'], true)
        && Modulo::query()->whereKey($moduloId)->where('habilitado', true)->exists();
});
