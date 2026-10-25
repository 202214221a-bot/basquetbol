<?php

namespace App\Http\Controllers;

use App\Models\Equipo;
use Illuminate\Http\Request;

class JugadorController extends Controller
{
    /**
     * Muestra los jugadores del equipo elegido.
     */
    public function index(Request $request)
    {
        $equipos = Equipo::orderBy('nombre')->get();

        // Equipo elegido en la lista desplegable; si no hay, se toma el primero
        $equipo = $equipos->firstWhere('id', (int) $request->query('equipo_id')) ?? $equipos->first();

        $jugadores = $equipo ? $equipo->jugadores()->orderBy('dorsal')->get() : collect();

        return view('jugadores.index', compact('equipos', 'equipo', 'jugadores'));
    }
}