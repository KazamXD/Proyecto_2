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

// Equipos
Route::get('/equipos', [EquipoController::class, 'index'])
    ->name('equipos.index');

// Categorías
Route::get('/categorias', [CategoriaController::class, 'index'])
    ->name('categorias.index');
