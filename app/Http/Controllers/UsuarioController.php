<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use App\Services\ServicioBitacora;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class UsuarioController extends Controller
{
    public function index(Request $request)
    {
        $buscar = trim((string) $request->query('buscar', ''));

        $consulta = Usuario::query()
            ->whereNull('desactivado_en');

        // Buscar por nombre, usuario o correo
        if ($buscar !== '') {
            $consulta->where(function ($query) use ($buscar) {
                $query->where('nombre', 'LIKE', "%{$buscar}%")
                    ->orWhere('apellido', 'LIKE', "%{$buscar}%")
                    ->orWhere('nom_usuario', 'LIKE', "%{$buscar}%")
                    ->orWhere('email', 'LIKE', "%{$buscar}%");
            });
        }

        // Obtener usuarios paginados
        $usuarios = $consulta
            ->orderBy('id', 'desc')
            ->paginate(10)
            ->withQueryString();

        return view('usuarios.index', compact(
            'usuarios',
            'buscar'
        ));
        
    }

    //Crear usuario
    public function create()
    {
        $roles = DB::table('rol')
            ->select('id_rol', 'nombre_rol')
            ->orderBy('nombre_rol')
            ->get();

        return view('usuarios.create', compact('roles'));
    }

    //Guardar el usuario
    public function store(Request $request)
    {
        // 1. Validar los datos del formulario
        $datos = $request->validate([
            'nombre' => 'required|string|max:100',
            'apellido' => 'required|string|max:100',
            'nom_usuario' => 'required|string|max:50|unique:usuarios,nom_usuario',
            'email' => 'required|email|max:255|unique:usuarios,email',
            'rol_id' => 'required|integer|exists:rol,id_rol',
            'password' => [
                'required',
                'confirmed',
                Password::min(10)->numbers(),
            ],
        ]);

        // 2. Guardar usuario y registrar en bitácora
        DB::transaction(function () use ($datos) {

            $usuario = new Usuario();

            $usuario->nombre = $datos['nombre'];
            $usuario->apellido = $datos['apellido'];
            $usuario->nom_usuario = $datos['nom_usuario'];
            $usuario->email = $datos['email'];
            $usuario->rol_id = $datos['rol_id'];

            // Nunca guardar la contraseña en texto plano
            $usuario->password_hash = Hash::make(
                $datos['password']
            );


            $usuario->save();

            // Registrar la operación en bitácora
            ServicioBitacora::registrar(
                (int) auth()->id(),
                'CREATE',
                'usuarios'
            );
        });

        // 3. Regresar al listado
        return redirect()
            ->route('usuarios.index')
            ->with('success', 'Usuario registrado correctamente.');
    }
}
