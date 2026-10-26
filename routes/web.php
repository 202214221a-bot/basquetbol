<?php

use App\Http\Controllers\AutenticacionController;
use App\Http\Controllers\EquipoController;
use App\Http\Controllers\JugadorController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PartidoController;

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

    Route::resource('equipos', EquipoController::class)->except('show');

    // Jugadores: se escriben a mano porque se crean dentro de un equipo
    Route::get('/jugadores', [JugadorController::class, 'index'])->name('jugadores.index');
    Route::get('/equipos/{equipo}/jugadores/crear', [JugadorController::class, 'create'])->name('jugadores.create');
    Route::post('/equipos/{equipo}/jugadores', [JugadorController::class, 'store'])->name('jugadores.store');
    Route::get('/jugadores/{jugador}/editar', [JugadorController::class, 'edit'])->name('jugadores.edit');
    Route::put('/jugadores/{jugador}', [JugadorController::class, 'update'])->name('jugadores.update');
    Route::delete('/jugadores/{jugador}', [JugadorController::class, 'destroy'])->name('jugadores.destroy');
    Route::resource('partidos', PartidoController::class)->only(['index', 'create', 'store', 'edit', 'update']);
    Route::resource('partidos', PartidoController::class)->except('show');
});

