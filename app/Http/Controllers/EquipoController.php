<?php

namespace App\Http\Controllers;

use App\Models\Equipo;

class EquipoController extends Controller
{
    /**
     * Muestra la lista de equipos ordenada por nombre.
     */
    public function index()
    {
        $equipos = Equipo::orderBy('nombre')->get();

        return view('equipos.index', compact('equipos'));
    }
}