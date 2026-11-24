<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CategoriaController extends Controller
{
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

        return view('categorias.index', compact('categorias', 'buscar'));
    }
}
