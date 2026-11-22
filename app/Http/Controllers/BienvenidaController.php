<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BienvenidaController extends Controller
{
    public function index()
    {
        $nombre = "Estudiante de Laravel";
        return view('bienvenida', ['nombre' => $nombre]);
    }
}
