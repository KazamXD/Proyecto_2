<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

use App\Http\Controllers\BienvenidaController;

Route::get('/bienvenida', [BienvenidaController::class, 'index']);