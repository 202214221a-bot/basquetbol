<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Jugador extends Model
{
    protected $table = 'jugadores';

    /**
     * Posiciones permitidas en el básquetbol.
     */
    public const POSICIONES = ['Base', 'Escolta', 'Alero', 'Ala-Pivot', 'Pivot'];

    protected $fillable = ['equipo_id', 'nombre', 'dorsal', 'posicion', 'estatura_cm'];

    /**
     * Un jugador pertenece a un equipo.
     */
    public function equipo(): BelongsTo
    {
        return $this->belongsTo(Equipo::class);
    }
}