<?php

namespace App\Http\Controllers;

use App\Models\Equipo;
use App\Models\Jugador;
use App\Models\Partido;

class EstadisticaController extends Controller
{
    /**
     * Muestra el resumen de la liga, la tabla de posiciones y los últimos resultados.
     */
    public function index()
    {
        $posiciones = Partido::tablaPosiciones();

        $recientes = Partido::with(['equipoLocal', 'equipoVisitante'])
            ->where('estado', 'finalizado')
            ->orderByDesc('fecha_hora')
            ->limit(5)
            ->get();

        $resumen = [
            'equipos'    => Equipo::count(),
            'jugadores'  => Jugador::count(),
            'jugados'    => Partido::where('estado', 'finalizado')->count(),
            'programados' => Partido::where('estado', 'programado')->count(),
        ];

        return view('estadisticas.index', compact('posiciones', 'recientes', 'resumen'));
    }
}