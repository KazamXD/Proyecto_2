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
        $limite = 15 * 60;
        $ahora = time();

        // Comprobar que el usuario continúe activo
        if (!Auth::user()->activo) {
            Auth::logout();

            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect()->route('login')
                ->with('mensaje', 'Tu cuenta está desactivada.');
        }

        // Detectar autenticación restaurada mediante Recordarme
        if (Auth::viaRemember()) {
            $request->session()->put('recordarme', true);
        }

        $recordarme = (bool) $request->session()->get('recordarme', false);

        $ultimaActividad = $request->session()
            ->get('ultima_actividad');

        if (
            !$recordarme &&
            $ultimaActividad !== null &&
            ($ahora - (int) $ultimaActividad) >= $limite
        ) {
            Auth::logout();

            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect()->route('login')
                ->with(
                    'mensaje',
                    'Tu sesión expiró por inactividad.'
                );
        }

        $request->session()->put('ultima_actividad', $ahora);

        return $next($request);
    }

}
