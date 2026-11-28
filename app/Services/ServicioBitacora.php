<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;

class ServicioBitacora
{
    public static function registrar(
        ?int $usuarioId,
        string $accion,
        string $entidad,
        ?int $entidadId = null,
        ?array $valoresAntes = null,
        ?array $valoresDespues = null
    ): void {
        DB::table('bitacora')->insert([
            'usuario_id' => $usuarioId,
            'accion' => $accion,
            'entidad' => $entidad,
            'entidad_id' => $entidadId,

            'valores_antes' => $valoresAntes !== null
                ? json_encode($valoresAntes, JSON_THROW_ON_ERROR)
                : null,

            'valores_despues' => $valoresDespues !== null
                ? json_encode($valoresDespues, JSON_THROW_ON_ERROR)
                : null,

            'ip' => request()->ip(),
        ]);
    }
}
