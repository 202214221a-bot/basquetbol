<?php

namespace App\Http\Controllers;

use App\Models\Equipo;
use Illuminate\Http\Request;

class EquipoController extends Controller
{
    /**
     * Muestra la lista de equipos ordenada por nombre.
     */
    public function index()
    {
        $equipos = Equipo::orderBy('nombre')->get();

        return view('equipos.index', compact('equipos'));
    }

    /**
     * Muestra el formulario para registrar un equipo nuevo.
     */
    public function create()
    {
        return view('equipos.formulario', ['equipo' => new Equipo()]);
    }

    /**
     * Valida los datos y guarda el equipo nuevo.
     */
    public function store(Request $request)
    {
        $datos = $request->validate([
            'nombre'         => ['required', 'string', 'max:100', 'unique:equipos,nombre'],
            'ciudad'         => ['required', 'string', 'max:100'],
            'anio_fundacion' => ['nullable', 'integer', 'between:1891,' . date('Y')],
        ], [
            'nombre.required'         => 'El nombre del equipo es obligatorio.',
            'nombre.unique'           => 'Ya existe un equipo con ese nombre.',
            'ciudad.required'         => 'La ciudad es obligatoria.',
            'anio_fundacion.integer'  => 'El año de fundación debe ser un número.',
            'anio_fundacion.between'  => 'El año de fundación debe estar entre 1891 y ' . date('Y') . '.',
        ]);

        Equipo::create($datos);

        return redirect()->route('equipos.index')->with('exito', 'Equipo creado correctamente.');
    }
}