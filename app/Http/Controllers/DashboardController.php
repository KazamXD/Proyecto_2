<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $usuario = Auth::user();

        // Comprobar que la cuenta siga activa
        if (!$usuario->activo) {
            Auth::logout();

            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect()->route('login')
                ->withErrors([
                    'nom_usuario' => 'Tu cuenta está desactivada.',
                ]);
        }

        // Consultar permisos del rol del usuario
        $permisos = DB::table('rol_permiso as rp')
            ->join(
                'permisos as p',
                'rp.permiso_id',
                '=',
                'p.id_permiso'
            )
            ->where('rp.rol_id', $usuario->rol_id)
            ->orderBy('p.clave')
            ->pluck('p.clave')
            ->all();

        // Permisos para los accesos rápidos
        $puedeCrearUsuarios = in_array(
            'usuarios.crear', $permisos, true
        );

        $puedeVerEquipos = in_array(
            'equipos.ver', $permisos, true
        );

        $puedeVerCategorias = in_array(
            'categorias.ver', $permisos, true
        );

        $puedeVerProveedores = in_array(
            'proveedores.ver', $permisos, true
        );

        $puedeCrearPrestamos = in_array(
            'prestamos.crear', $permisos, true
        );

        $puedeCrearSolicitudes = in_array(
            'solicitudes.crear', $permisos, true
        );

        return view('dashboard', compact(
            'usuario',
            'permisos',
            'puedeCrearUsuarios',
            'puedeVerEquipos',
            'puedeVerCategorias',
            'puedeVerProveedores',
            'puedeCrearPrestamos',
            'puedeCrearSolicitudes'
        ));
    }
}
