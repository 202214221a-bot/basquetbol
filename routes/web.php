<?php

use App\Http\Controllers\AutenticacionController;
use App\Http\Controllers\EquipoController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('inicio');
});

// Páginas solo para visitantes que NO han iniciado sesión
Route::middleware('guest')->group(function () {
    Route::get('/registro', [AutenticacionController::class, 'mostrarRegistro'])->name('registro');
    Route::post('/registro', [AutenticacionController::class, 'registrar']);

    Route::get('/ingresar', [AutenticacionController::class, 'mostrarIngreso'])->name('login');
    Route::post('/ingresar', [AutenticacionController::class, 'ingresar']);
});

// Páginas solo para usuarios que SÍ iniciaron sesión
Route::middleware('auth')->group(function () {
    Route::get('/inicio', function () {
        return view('inicio');
    })->name('inicio');

    Route::post('/salir', [AutenticacionController::class, 'salir'])->name('salir');

    Route::resource('equipos', EquipoController::class)->only(['index', 'create', 'store']);

});