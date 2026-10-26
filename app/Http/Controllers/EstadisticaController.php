<?php

namespace App\Http\Controllers;

use App\Models\Partido;

class EstadisticaController extends Controller
{
    /**
     * Muestra la tabla de posiciones de la liga.
     */
    public function index()
    {
        $posiciones = Partido::tablaPosiciones();

        return view('estadisticas.index', compact('posiciones'));
    }
}