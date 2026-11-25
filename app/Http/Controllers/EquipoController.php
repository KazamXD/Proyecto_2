<?php

namespace App\Http\Controllers;

use App\Models\Equipo;
use Illuminate\Http\Request;
use Illuminate\View\View;

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
                            $categoria->where(
                                'categoria_nombre',
                                'LIKE',
                                "%{$buscar}%"
                            )->whereNull('eliminado_en');
                        });
                });
            })
            ->orderBy('codigo')
            ->paginate(10)
            ->withQueryString();

        return view('equipos.index', compact('equipos', 'buscar'));
    }
}
