<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;

class ServicioBitacora
{
    public static function registrar(
        ?int $usuarioId,
        string $accion,
        string $entidad
    ): void {
        DB::table('bitacora')->insert([
            'usuario_id' => $usuarioId,
            'accion' => $accion,
            'entidad' => $entidad,
            'ip' => request()->ip(),
        ]);
    }
}
