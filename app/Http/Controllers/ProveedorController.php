<?php

namespace App\Http\Controllers;

use App\Models\Proveedor;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ProveedorController extends Controller
{
    // Mostrar proveedores activos.
    public function index(Request $request): View
    {
        $buscar = $request->input('buscar');

        $proveedores = Proveedor::whereNull('eliminado_en')
            ->when($buscar, function ($query, $buscar) {
                $query->where(function ($consulta) use ($buscar) {
                    $consulta->where('nombre', 'like', "%{$buscar}%")
                        ->orWhere('nombre_contacto', 'like', "%{$buscar}%")
                        ->orWhere('telefono', 'like', "%{$buscar}%")
                        ->orWhere('email', 'like', "%{$buscar}%");
                });
            })
            ->orderBy('nombre')
            ->paginate(10)
            ->withQueryString();

        $permisos = DB::table('rol_permiso as rp')
            ->join('permisos as p', 'rp.permiso_id', '=', 'p.id_permiso')
            ->where('rp.rol_id', Auth::user()->rol_id)
            ->pluck('p.clave')
            ->all();

        return view('proveedores.index', compact('proveedores', 'buscar', 'permisos'));
    }

    // Mostrar formulario de creación.
    public function create(): View
    {
        return view('proveedores.create');
    }

    // Guardar proveedor.
    public function store(Request $request): RedirectResponse
    {
        $datos = $request->validate([
            'nombre' => 'required|string|max:150',
            'nombre_contacto' => 'nullable|string|max:100',
            'telefono' => 'nullable|string|max:30',
            'email' => 'nullable|email|max:150',
            'direccion' => 'nullable|string',
            'informacion_general' => 'nullable|string',
        ]);

        Proveedor::create($datos);

        return redirect()->route('proveedores.index')
            ->with('success', 'Proveedor registrado correctamente.');
    }

    // Mostrar formulario de edición.
    public function edit(int $id): View
    {
        $proveedor = Proveedor::whereNull('eliminado_en')->findOrFail($id);

        return view('proveedores.edit', compact('proveedor'));
    }

    // Actualizar proveedor.
    public function update(Request $request, int $id): RedirectResponse
    {
        $proveedor = Proveedor::whereNull('eliminado_en')->findOrFail($id);

        $datos = $request->validate([
            'nombre' => 'required|string|max:150',
            'nombre_contacto' => 'nullable|string|max:100',
            'telefono' => 'nullable|string|max:30',
            'email' => 'nullable|email|max:150',
            'direccion' => 'nullable|string',
            'informacion_general' => 'nullable|string',
        ]);

        $proveedor->update($datos);

        return redirect()->route('proveedores.index')
            ->with('success', 'Proveedor actualizado correctamente.');
    }

    // Eliminar proveedor lógicamente.
    public function destroy(int $id): RedirectResponse
    {
        $proveedor = Proveedor::whereNull('eliminado_en')->findOrFail($id);

        $proveedor->update([
            'eliminado_en' => now(),
        ]);

        return redirect()->route('proveedores.index')
            ->with('success', 'Proveedor eliminado correctamente.');
    }
}
