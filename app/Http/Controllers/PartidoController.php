<?php

namespace App\Http\Controllers;

use App\Models\Partido;

class PartidoController extends Controller
{
    /**
     * Muestra la lista de partidos, del más reciente al más antiguo.
     */
    public function index()
    {
        $partidos = Partido::with(['equipoLocal', 'equipoVisitante'])
            ->orderByDesc('fecha_hora')
            ->get();

        return view('partidos.index', compact('partidos'));
    }
}