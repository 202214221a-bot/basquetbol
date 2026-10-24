<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Equipo extends Model
{
    protected $table = 'equipos';

    /**
     * Campos que se pueden llenar desde un formulario.
     */
    protected $fillable = ['nombre', 'ciudad', 'anio_fundacion'];
}