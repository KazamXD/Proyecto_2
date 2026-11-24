<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BienvenidaController;
use App\Http\Controllers\EquipoController;
use App\Http\Controllers\CategoriaController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/bienvenida', [BienvenidaController::class, 'index']);

Route::get('/equipos', [EquipoController::class, 'index'])
    ->name('equipos.index');

Route::get('/categorias', [CategoriaController::class, 'index'])
    ->name('categorias.index');
