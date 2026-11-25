<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EquipoController;
use App\Http\Controllers\CategoriaController;

Route::get('/', function () {
    return auth()->check()
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

// Equipos: requiere autenticación y permiso para consultar
Route::get('/equipos', [EquipoController::class, 'index'])
    ->middleware(['auth', 'permiso:equipos.ver'])
    ->name('equipos.index');

// Categorías: requiere autenticación y permiso para consultar
Route::get('/categorias', [CategoriaController::class, 'index'])
    ->middleware(['auth', 'permiso:categorias.ver'])
    ->name('categorias.index');
