<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EquipoController;
use App\Http\Controllers\CategoriaController;

Route::get('/', function () {
    return Auth::check()
        ? redirect()->route('dashboard')
        : redirect()->route('login');
})->name('inicio');

// Autenticación
Route::get('/login', [AuthController::class, 'mostrarLogin'])
    ->middleware('guest')
    ->name('login');

Route::post('/login', [AuthController::class, 'login'])
    ->name('login.procesar');

Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');

// Dashboard
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware('auth')
    ->name('dashboard');

// Equipos
Route::get('/equipos', [EquipoController::class, 'index'])
    ->middleware(['auth', 'permiso:equipos.ver'])
    ->name('equipos.index');

// Categorías
Route::middleware('auth')->group(function () {

    Route::get('/categorias', [CategoriaController::class, 'index'])
        ->middleware('permiso:categorias.ver')
        ->name('categorias.index');

    Route::get('/categorias/crear', [CategoriaController::class, 'create'])
        ->middleware('permiso:categorias.crear')
        ->name('categorias.create');

    Route::post('/categorias', [CategoriaController::class, 'store'])
        ->middleware('permiso:categorias.crear')
        ->name('categorias.store');

    Route::get('/categorias/{categoria}/editar', [CategoriaController::class, 'edit'])
        ->middleware('permiso:categorias.editar')
        ->name('categorias.edit');

    Route::put('/categorias/{categoria}', [CategoriaController::class, 'update'])
        ->middleware('permiso:categorias.editar')
        ->name('categorias.update');

    Route::delete('/categorias/{categoria}', [CategoriaController::class, 'destroy'])
        ->middleware('permiso:categorias.eliminar')
        ->name('categorias.destroy');
});
