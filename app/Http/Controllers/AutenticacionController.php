<?php

namespace App\Http\Controllers;

class AutenticacionController extends Controller
{
    /**
     * Muestra el formulario para crear una cuenta nueva.
     */
    public function mostrarRegistro()
    {
        return view('autenticacion.registro');
    }
}