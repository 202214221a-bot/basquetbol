<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Collection;

class Partido extends Model
{
    protected $table = 'partidos';

    protected $fillable = [
        'equipo_local_id',
        'equipo_visitante_id',
        'fecha_hora',
        'estado',
        'puntos_local',
        'puntos_visitante',
    ];

    /**
     * Convierte fecha_hora en una fecha que se puede formatear fácilmente.
     */
    protected $casts = [
        'fecha_hora' => 'datetime',
    ];

    /**
     * Un partido tiene un equipo local.
     */
    public function equipoLocal(): BelongsTo
    {
        return $this->belongsTo(Equipo::class, 'equipo_local_id');
    }

    /**
     * Un partido tiene un equipo visitante.
     */
    public function equipoVisitante(): BelongsTo
    {
        return $this->belongsTo(Equipo::class, 'equipo_visitante_id');
    }

    /**
     * Indica si el partido ya se jugó y tiene resultado.
     */
    public function estaFinalizado(): bool
    {
        return $this->estado === 'finalizado';
    }

        /**
     * Calcula la tabla de posiciones con los partidos finalizados.
     * Cada victoria da 2 puntos y cada derrota 1 punto.
     * Si dos equipos empatan en puntos, desempata la diferencia de puntos.
     */
    public static function tablaPosiciones(): Collection
    {
        $partidos = static::where('estado', 'finalizado')->get();

        return Equipo::all()->map(function (Equipo $equipo) use ($partidos) {
            $jugados = 0;
            $ganados = 0;
            $favor = 0;
            $contra = 0;

            foreach ($partidos as $partido) {
                if ((int) $partido->equipo_local_id === $equipo->id) {
                    $propios = $partido->puntos_local;
                    $rival = $partido->puntos_visitante;
                } elseif ((int) $partido->equipo_visitante_id === $equipo->id) {
                    $propios = $partido->puntos_visitante;
                    $rival = $partido->puntos_local;
                } else {
                    continue; // este partido no es de este equipo
                }

                $jugados++;
                $favor += $propios;
                $contra += $rival;

                if ($propios > $rival) {
                    $ganados++;
                }
            }

            $perdidos = $jugados - $ganados;

            return (object) [
                'nombre'      => $equipo->nombre,
                'jugados'     => $jugados,
                'ganados'     => $ganados,
                'perdidos'    => $perdidos,
                'a_favor'     => $favor,
                'en_contra'   => $contra,
                'diferencia'  => $favor - $contra,
                'puntos_liga' => $ganados * 2 + $perdidos,
            ];
        })->sort(function ($a, $b) {
            return [$b->puntos_liga, $b->diferencia] <=> [$a->puntos_liga, $a->diferencia];
        })->values();
    }
}