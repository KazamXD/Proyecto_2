<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Models\Equipo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class EquipoController extends Controller
{
    public function index(Request $request): View
    {
        $buscar = $request->input('buscar');

        $equipos = Equipo::with('categoria')
            ->whereNull('eliminado_en')
            ->when($buscar, function ($query, $buscar) {
                $query->where(function ($consulta) use ($buscar) {
                    $consulta->where('codigo', 'LIKE', "%{$buscar}%")
                        ->orWhere('nombre_estado', 'LIKE', "%{$buscar}%")
                        ->orWhereHas('categoria', function ($categoria) use ($buscar) {
                            $categoria->where('categoria_nombre', 'LIKE', "%{$buscar}%")
                                ->whereNull('eliminado_en');
                        });
                });
            })
            ->orderBy('codigo')
            ->paginate(10)
            ->withQueryString();

        $permisos = DB::table('rol_permiso as rp')
            ->join('permisos as p', 'rp.permiso_id', '=', 'p.id_permiso')
            ->where('rp.rol_id', Auth::user()->rol_id)
            ->pluck('p.clave')
            ->all();

        return view('equipos.index', compact('equipos', 'buscar', 'permisos'));
    }

    public function create(): View
    {
        $categorias = Categoria::whereNull('eliminado_en')
            ->orderBy('categoria_nombre')
            ->get();

        return view('equipos.create', compact('categorias'));
    }

    public function store(Request $request): RedirectResponse
    {
        $datos = $request->validate([
            'id_categoria' => [
                'required',
                'integer',
                Rule::exists('categorias', 'categoria_id')
                    ->whereNull('eliminado_en'),
            ],
            'codigo' => ['required', 'string', 'max:30', 'unique:equipos,codigo'],
            'nombre_estado' => ['required', 'string', 'max:50'],
            'imagen' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ]);

        if ($request->hasFile('imagen')) {
            $datos['ruta_imagen'] = $request->file('imagen')->store('equipos', 'public');
        }

        unset($datos['imagen']);

        Equipo::create($datos);

        return redirect()->route('equipos.index')
            ->with('success', 'Equipo registrado correctamente.');
    }

    public function edit(int $equipo): View
    {
        $equipo = Equipo::whereNull('eliminado_en')
            ->findOrFail($equipo);

        $categorias = Categoria::whereNull('eliminado_en')
            ->orderBy('categoria_nombre')
            ->get();

        return view('equipos.edit', compact('equipo', 'categorias'));
    }

    public function update(Request $request, int $equipo): RedirectResponse
    {
        $equipo = Equipo::whereNull('eliminado_en')
            ->findOrFail($equipo);

        $datos = $request->validate([
            'id_categoria' => [
                'required',
                'integer',
                Rule::exists('categorias', 'categoria_id')
                    ->whereNull('eliminado_en'),
            ],
            'codigo' => [
                'required',
                'string',
                'max:30',
                Rule::unique('equipos', 'codigo')->ignore($equipo->id_equipo, 'id_equipo'),
            ],
            'nombre_estado' => ['required', 'string', 'max:50'],
            'imagen' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ]);

        unset($datos['imagen']);

        if ($request->hasFile('imagen')) {
            $imagenAnterior = $equipo->ruta_imagen;

            $datos['ruta_imagen'] = $request->file('imagen')->store('equipos', 'public');

            if ($imagenAnterior && str_starts_with($imagenAnterior, 'equipos/')) {
                Storage::disk('public')->delete($imagenAnterior);
            }
        }

        $equipo->update($datos);

        return redirect()->route('equipos.index')
            ->with('success', 'Equipo actualizado correctamente.');
    }

    public function destroy(int $equipo): RedirectResponse
    {
        $equipo = Equipo::whereNull('eliminado_en')
            ->findOrFail($equipo);

        $tienePrestamoActivo = DB::table('prestamo_detalle as pd')
            ->join('prestamos as p', 'pd.prestamo_id', '=', 'p.id_prestamo')
            ->where('pd.equipo_id', $equipo->id_equipo)
            ->whereIn('p.estado', ['prestado', 'retrasado'])
            ->exists();

        if ($tienePrestamoActivo) {
            return redirect()->route('equipos.index')
                ->with('error', 'No se puede eliminar el equipo porque tiene un préstamo activo o retrasado.');
        }

        $equipo->update([
            'eliminado_en' => now(),
        ]);

        return redirect()->route('equipos.index')
            ->with('success', 'Equipo eliminado correctamente.');
    }
}
