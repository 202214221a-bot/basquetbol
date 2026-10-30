<?php

namespace App\Http\Controllers;

use App\Models\Equipo;
use App\Models\Jugador;
use App\Models\Partido;

class EstadisticaController extends Controller
{
    /**
     * Página de inicio: totales, líder actual y próximos partidos.
     */
    public function inicio()
    {
        $proximos = Partido::with(['equipoLocal', 'equipoVisitante'])
            ->where('estado', 'programado')
            ->orderBy('fecha_hora')
            ->limit(5)
            ->get();

        // El primero de la tabla de posiciones es el líder (null si no hay equipos)
        $lider = Partido::tablaPosiciones()->first();

        return view('inicio', [
            'resumen'  => $this->resumen(),
            'proximos' => $proximos,
            'lider'    => $lider,
        ]);
    }

    /**
     * Estadísticas: resumen, tabla de posiciones y últimos resultados.
     */
    public function index()
    {
        $posiciones = Partido::tablaPosiciones();

        $recientes = Partido::with(['equipoLocal', 'equipoVisitante'])
            ->where('estado', 'finalizado')
            ->orderByDesc('fecha_hora')
            ->limit(5)
            ->get();

        $resumen = $this->resumen();

        return view('estadisticas.index', compact('posiciones', 'recientes', 'resumen'));
    }

    /**
     * Totales de la liga. Lo usan las dos páginas, por eso se escribe una sola vez.
     */
    private function resumen(): array
    {
        return [
            'equipos'     => Equipo::count(),
            'jugadores'   => Jugador::count(),
            'jugados'     => Partido::where('estado', 'finalizado')->count(),
            'programados' => Partido::where('estado', 'programado')->count(),
        ];
    }
}