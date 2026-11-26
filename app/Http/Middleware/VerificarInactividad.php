<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class VerificarInactividad
{
    public function handle(Request $request, Closure $next): Response
    {
        $limite = 15 * 60; // 15 minutos en segundos

        $ahora = time();

        $ultimaActividad = $request->session()
            ->get('ultima_actividad');

        // Verificar el tiempo transcurrido
        if (
            $ultimaActividad !== null &&
            ($ahora - (int) $ultimaActividad) >= $limite
        ) {
            // Cerrar sesión
            Auth::logout();

            // Invalidar la sesión anterior
            $request->session()->invalidate();

            // Generar un nuevo token CSRF
            $request->session()->regenerateToken();

            return redirect()
                ->route('login')
                ->with(
                    'mensaje',
                    'Tu sesión expiró por inactividad. Inicia sesión nuevamente.'
                );
        }

        // Actualizar la última actividad
        $request->session()->put('ultima_actividad', $ahora);

        return $next($request);
    }
}
