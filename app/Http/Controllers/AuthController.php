<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function mostrarLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $datos = $request->validate([
            'nom_usuario' => 'required|string',
            'password' => 'required|string',
        ]);

        $credenciales = [
            'nom_usuario' => $datos['nom_usuario'],
            'password' => $datos['password'],
            'activo' => 1,
        ];

        if (Auth::attempt($credenciales)) {

            $request->session()->regenerate();

            return redirect()->route('dashboard');
        }

        return back()->withErrors([
            'nom_usuario' => 'Credenciales incorrectas.',
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
