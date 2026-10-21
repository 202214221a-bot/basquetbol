<?php

use App\Http\Controllers\AutenticacionController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/registro', [AutenticacionController::class, 'mostrarRegistro'])->name('registro');