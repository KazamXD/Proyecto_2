<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EquipoController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\UsuarioController;


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
    ->middleware(['auth', 'inactividad'])
    ->name('dashboard');

// -----------  Usuarios  -----------
// ver usuarios
Route::get('/usuarios', [UsuarioController::class, 'index'])
    ->middleware([
        'auth',
        'inactividad',
        'permiso:usuarios.ver',
    ])
    ->name('usuarios.index');
// Crear usuarios, es mas como mostrar el formulario
Route::get('/usuarios/create', [UsuarioController::class, 'create'])
    ->middleware([
        'auth',
        'inactividad',
        'permiso:usuarios.crear',
    ])
    ->name('usuarios.create');
//Guardar el usuario
Route::post('/usuarios', [UsuarioController::class, 'store'])
    ->middleware([
        'auth',
        'inactividad',
        'permiso:usuarios.crear',
    ])
    ->name('usuarios.store');

// -----------  Equipos  -----------
// Ver equipos
Route::get('/equipos', [EquipoController::class, 'index'])
    ->middleware(['auth', 'permiso:equipos.ver'])
    ->name('equipos.index');

// -----------  Categorías  -----------

Route::middleware('auth')->group(function () {
    // Ver categorías
    Route::get('/categorias', [CategoriaController::class, 'index'])
        ->middleware('permiso:categorias.ver')
        ->name('categorias.index');
    //Crear categorías
    Route::get('/categorias/crear', [CategoriaController::class, 'create'])
        ->middleware('permiso:categorias.crear')
        ->name('categorias.create');

    Route::post('/categorias', [CategoriaController::class, 'store'])
        ->middleware('permiso:categorias.crear')
        ->name('categorias.store');
    //Editar categorías
    Route::get('/categorias/{categoria}/editar', [CategoriaController::class, 'edit'])
        ->middleware('permiso:categorias.editar')
        ->name('categorias.edit');

    Route::put('/categorias/{categoria}', [CategoriaController::class, 'update'])
        ->middleware('permiso:categorias.editar')
        ->name('categorias.update');
    //Eliminar categorías
    Route::delete('/categorias/{categoria}', [CategoriaController::class, 'destroy'])
        ->middleware('permiso:categorias.eliminar')
        ->name('categorias.destroy');

    //Ruta para probar permisos de usuarios
    /*Route::get('/prueba-permisos', function () {
        return 'Acceso autorizado correctamente.';
    })->middleware([
        'auth',
        'inactividad',
        'permiso:usuarios.ver',
    ]);*/

    
});

// Crear equipos
Route::get('/equipos/crear', [EquipoController::class, 'create'])
    ->middleware(['auth', 'inactividad', 'permiso:equipos.crear'])
    ->name('equipos.create');

Route::post('/equipos', [EquipoController::class, 'store'])
    ->middleware(['auth', 'inactividad', 'permiso:equipos.crear'])
    ->name('equipos.store');

// Editar equipos
Route::get('/equipos/{equipo}/editar', [EquipoController::class, 'edit'])
    ->middleware(['auth', 'inactividad', 'permiso:equipos.editar'])
    ->name('equipos.edit');

Route::put('/equipos/{equipo}', [EquipoController::class, 'update'])
    ->middleware(['auth', 'inactividad', 'permiso:equipos.editar'])
    ->name('equipos.update');

// Eliminar equipos
Route::delete('/equipos/{equipo}', [EquipoController::class, 'destroy'])
    ->middleware(['auth', 'inactividad', 'permiso:equipos.eliminar'])
    ->name('equipos.destroy');
