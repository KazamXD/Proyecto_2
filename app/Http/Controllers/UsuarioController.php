<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use App\Services\ServicioBitacora;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
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

        // Comprobar permiso para editar usuarios
        $puedeEditar = DB::table('rol_permiso as rp')
            ->join('permisos as p', 'rp.permiso_id', '=', 'p.id_permiso')
            ->where('rp.rol_id', auth()->user()->rol_id)
            ->where('p.clave', 'usuarios.editar')
            ->exists();

        // Comprobar permiso para eliminar usuarios
        $puedeEliminar = DB::table('rol_permiso as rp')
            ->join('permisos as p', 'rp.permiso_id', '=', 'p.id_permiso')
            ->where('rp.rol_id', auth()->user()->rol_id)
            ->where('p.clave', 'usuarios.eliminar')
            ->exists();

        // Enviar los datos a la vista
        return view('usuarios.index', compact(
            'usuarios',
            'buscar',
            'puedeEditar',
            'puedeEliminar'
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
        DB::transaction(function () use ($usuario, $datos) {

            $usuario->nombre = $datos['nombre'];
            $usuario->apellido = $datos['apellido'];
            $usuario->nom_usuario = $datos['nom_usuario'];
            $usuario->email = $datos['email'];
            $usuario->rol_id = $datos['rol_id'];

            if (!empty($datos['password'])) {
                $usuario->password_hash = Hash::make($datos['password']);
            }

            // Obtener los campos modificados
            $cambios = $usuario->getDirty();

            // Guardar los cambios
            $usuario->save();

            // Aquí registraremos los valores anteriores y nuevos
        });

        // 3. Regresar al listado
        return redirect()
            ->route('usuarios.index')
            ->with('success', 'Usuario registrado correctamente.');
    }

    //Editar usuario
    public function edit(Usuario $usuario)
    {
        if ($usuario->desactivado_en !== null) {
            abort(404);
        }

        $roles = DB::table('rol')
            ->select('id_rol', 'nombre_rol')
            ->orderBy('nombre_rol')
            ->get();

        return view('usuarios.edit', compact(
            'usuario',
            'roles'
        ));
    }

    //Metodo update

    public function update(Request $request, Usuario $usuario)
    {
        // No permitir editar usuarios eliminados lógicamente
        if ($usuario->desactivado_en !== null) {
            abort(404);
        }

        $datos = $request->validate([
            'nombre' => 'required|string|max:100',
            'apellido' => 'required|string|max:100',

            'nom_usuario' => [
                'required',
                'string',
                'max:50',
                Rule::unique('usuarios', 'nom_usuario')
                    ->ignore($usuario),
            ],

            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('usuarios', 'email')
                    ->ignore($usuario),
            ],

            'rol_id' => 'required|integer|exists:rol,id_rol',

            'password' => [
                'nullable',
                'confirmed',
                Password::min(10)->numbers(),
            ],
        ]);

        
        DB::transaction(function () use ($usuario, $datos) {

            // Guardamos los valores antes de modificarlos
            $valoresAntes = [
                'nombre' => $usuario->nombre,
                'apellido' => $usuario->apellido,
                'nom_usuario' => $usuario->nom_usuario,
                'email' => $usuario->email,
                'rol_id' => $usuario->rol_id,
            ];

            // Asignamos los datos nuevos
            $usuario->nombre = $datos['nombre'];
            $usuario->apellido = $datos['apellido'];
            $usuario->nom_usuario = $datos['nom_usuario'];
            $usuario->email = $datos['email'];
            $usuario->rol_id = $datos['rol_id'];

            $cambioContrasena = !empty($datos['password']);

            if ($cambioContrasena) {
                $usuario->password_hash = Hash::make(
                    $datos['password']
                );
            }

            // Valores nuevos, antes de guardar
            $valoresDespues = [
                'nombre' => $usuario->nombre,
                'apellido' => $usuario->apellido,
                'nom_usuario' => $usuario->nom_usuario,
                'email' => $usuario->email,
                'rol_id' => $usuario->rol_id,
            ];

            // Registrar solamente los campos que cambiaron
            $cambiosAntes = [];
            $cambiosDespues = [];

            foreach ($valoresAntes as $campo => $valorAnterior) {
                if ($valorAnterior != $valoresDespues[$campo]) {
                    $cambiosAntes[$campo] = $valorAnterior;
                    $cambiosDespues[$campo] = $valoresDespues[$campo];
                }
            }

            if ($cambioContrasena) {
                $cambiosAntes['contrasena_modificada'] = false;
                $cambiosDespues['contrasena_modificada'] = true;
            }

            // Solo guardar y auditar si hubo modificaciones
            if (!empty($cambiosDespues)) {
                $usuario->save();

                ServicioBitacora::registrar(
                    (int) auth()->id(),
                    'UPDATE',
                    'usuarios',
                    (int) $usuario->id,
                    $cambiosAntes,
                    $cambiosDespues
                );
            }
        });

        // Redirigir a usuarios index
        return redirect()
            ->route('usuarios.index')
            ->with('success', 'Usuario actualizado correctamente.');
        
    }

    //Eliminar usuarios
    public function destroy(Usuario $usuario)
    {
        // No permitir eliminar el usuario autenticado
        if ((int) auth()->id() === (int) $usuario->id) {
            return redirect()
                ->route('usuarios.index')
                ->with('error', 'No puedes eliminar tu propia cuenta.');
        }

        // No eliminar dos veces el mismo usuario
        if ($usuario->desactivado_en !== null) {
            return redirect()
                ->route('usuarios.index')
                ->with('error', 'Este usuario ya está desactivado.');
        }

        DB::transaction(function () use ($usuario) {

            $valoresAntes = [
                'desactivado_en' => null,
                'activo' => (int) $usuario->activo,
            ];

            // Eliminación lógica: no se elimina el registro
            $usuario->desactivado_en = now();
            $usuario->save();

            // Refrescar para obtener el valor generado de activo
            $usuario->refresh();

            $valoresDespues = [
                'desactivado_en' => $usuario->desactivado_en,
                'activo' => (int) $usuario->activo,
            ];

            ServicioBitacora::registrar(
                (int) auth()->id(),
                'DELETE',
                'usuarios',
                (int) $usuario->id,
                $valoresAntes,
                $valoresDespues
            );
        });

        return redirect()
            ->route('usuarios.index')
            ->with('success', 'Usuario desactivado correctamente.');
    }

}