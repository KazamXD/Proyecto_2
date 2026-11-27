<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;

class AuthController extends Controller
{
    public function mostrarLogin()
    {
        return view('auth.login');
    }

    
    public function login(Request $request)
    {
        // 1. Validar los datos del formulario
        $datos = $request->validate([
            'nom_usuario' => 'required|string',
            'password' => 'required|string',
        ]);

        $nombreUsuario = $datos['nom_usuario'];

        // 2. Crear una clave única por usuario e IP
        $clave = 'login:' . hash(
            'sha256',
            mb_strtolower($nombreUsuario, 'UTF-8')
            . '|' . $request->ip()
        );

        $maxIntentos = 3;
        $tiempoBloqueo = 300; // 5 minutos en segundos

        // 3. Comprobar si el usuario está bloqueado
        if (RateLimiter::tooManyAttempts($clave, $maxIntentos)) {
            $segundos = RateLimiter::availableIn($clave);
            $minutos = (int) ceil($segundos / 60);

            return back()->withErrors([
                'nom_usuario' => "Demasiados intentos fallidos. Intenta nuevamente en {$minutos} minuto(s).",
            ])->onlyInput('nom_usuario');
        }

        // 4. Preparar las credenciales para Laravel
        $credenciales = [
            'nom_usuario' => $nombreUsuario,
            'password' => $datos['password'],
            'activo' => 1,
        ];

        //Recordarme de 14 días
        $recordarme = $request->boolean('recordarme');

        // 5. Intentar iniciar sesión
        if (Auth::attempt($credenciales, $recordarme)) {

            RateLimiter::clear($clave);

            $request->session()->regenerate();

            // Registrar el inicio del período de actividad
            $request->session()->put('ultima_actividad', time());
            $request->session()->put('recordarme', $recordarme);

            return redirect()->route('dashboard');
        }

        // 6. Registrar un intento fallido
        RateLimiter::hit($clave, $tiempoBloqueo);

        // 7. Bloquear al alcanzar el tercer intento
        if (RateLimiter::tooManyAttempts($clave, $maxIntentos)) {
            return back()->withErrors([
                'nom_usuario' => 'Demasiados intentos fallidos. Acceso bloqueado temporalmente durante 5 minutos.',
            ])->onlyInput('nom_usuario');
        }

        // 8. Informar que las credenciales son incorrectas
        $restantes = RateLimiter::remaining($clave, $maxIntentos);

        return back()->withErrors([
            'nom_usuario' => "Credenciales incorrectas. Te quedan {$restantes} intento(s).",
        ])->onlyInput('nom_usuario');
    }


    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
