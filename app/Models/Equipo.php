<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Equipo extends Model
{
    protected $table = 'equipos';

    /**
     * Campos que se pueden llenar desde un formulario.
     */
    protected $fillable = ['nombre', 'ciudad', 'anio_fundacion'];

    /**
     * Un equipo tiene muchos jugadores.
     */
    public function jugadores(): HasMany
    {
        return $this->hasMany(Jugador::class);
    }
}