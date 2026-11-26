<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CategoriaController extends Controller
{
    // Mostrar categorías
    public function index(Request $request): View
    {
        $buscar = $request->input('buscar');

        $categorias = Categoria::withCount([
            'equipos' => function ($query) {
                $query->whereNull('eliminado_en');
            }
        ])
            ->whereNull('eliminado_en')
            ->when($buscar, function ($query, $buscar) {
                $query->where(
                    'categoria_nombre',
                    'LIKE',
                    "%{$buscar}%"
                );
            })
            ->orderBy('categoria_nombre')
            ->paginate(10)
            ->withQueryString();

        $permisos = DB::table('rol_permiso as rp')
            ->join('permisos as p', 'rp.permiso_id', '=', 'p.id_permiso')
            ->where('rp.rol_id', Auth::user()->rol_id)
            ->pluck('p.clave')
            ->all();

        return view('categorias.index', compact('categorias', 'buscar', 'permisos'));
    }

    // Mostrar formulario de creación
    public function create(): View
    {
        return view('categorias.create');
    }

    // Guardar nueva categoría
    public function store(Request $request): RedirectResponse
    {
        $datos = $request->validate([
            'categoria_nombre' => [
                'required',
                'string',
                'max:50',
                Rule::unique('categorias', 'categoria_nombre')
                    ->whereNull('eliminado_en'),
            ],
            'dias_max_prestamo' => [
                'required',
                'integer',
                'min:1',
            ],
        ]);

        Categoria::create($datos);

        return redirect()
            ->route('categorias.index')
            ->with('success', 'Categoría registrada correctamente.');
    }

    // Mostrar formulario de edición
    public function edit(int $categoria): View
    {
        $categoria = Categoria::whereNull('eliminado_en')
            ->findOrFail($categoria);

        return view('categorias.edit', compact('categoria'));
    }

    // Actualizar categoría
    public function update(Request $request, int $categoria): RedirectResponse
    {
        $categoria = Categoria::whereNull('eliminado_en')
            ->findOrFail($categoria);

        $datos = $request->validate([
            'categoria_nombre' => [
                'required',
                'string',
                'max:50',
                Rule::unique('categorias', 'categoria_nombre')
                    ->whereNull('eliminado_en')
                    ->ignore($categoria->categoria_id, 'categoria_id'),
            ],
            'dias_max_prestamo' => [
                'required',
                'integer',
                'min:1',
            ],
        ]);

        $categoria->update($datos);

        return redirect()
            ->route('categorias.index')
            ->with('success', 'Categoría actualizada correctamente.');
    }

    // Eliminar categoría lógicamente
    public function destroy(int $categoria): RedirectResponse
    {
        $categoria = Categoria::whereNull('eliminado_en')
            ->findOrFail($categoria);

        $tieneEquipos = $categoria->equipos()
            ->whereNull('eliminado_en')
            ->exists();

        if ($tieneEquipos) {
            return redirect()
                ->route('categorias.index')
                ->with('error', 'No se puede eliminar una categoría que tiene equipos activos asociados.');
        }

        $categoria->update([
            'eliminado_en' => now(),
        ]);

        return redirect()
            ->route('categorias.index')
            ->with('success', 'Categoría eliminada correctamente.');
    }
}
