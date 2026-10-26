<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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
}