<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

class VerificarPermiso
{
    public function handle(
        Request $request,
        Closure $next,
        string $permiso
    ): Response {
        $usuario = Auth::user();

        if (!$usuario) {
            abort(401, 'Debes iniciar sesión.');
        }

        $tienePermiso = DB::table('rol_permiso as rp')
            ->join(
                'permisos as p',
                'rp.permiso_id',
                '=',
                'p.id_permiso'
            )
            ->where('rp.rol_id', $usuario->rol_id)
            ->where('p.clave', $permiso)
            ->exists();

        if (!$tienePermiso) {
            abort(403, 'No tienes permiso para acceder a este módulo.');
        }

        return $next($request);
    }
}
