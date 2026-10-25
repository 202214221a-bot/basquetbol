<?php

namespace App\Http\Controllers;

use App\Models\Equipo;
use App\Models\Jugador;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class JugadorController extends Controller
{
    /**
     * Muestra los jugadores del equipo elegido.
     */
    public function index(Request $request)
    {
        $equipos = Equipo::orderBy('nombre')->get();

        // Equipo elegido en la lista desplegable; si no hay, se toma el primero
        $equipo = $equipos->firstWhere('id', (int) $request->query('equipo_id')) ?? $equipos->first();

        $jugadores = $equipo ? $equipo->jugadores()->orderBy('dorsal')->get() : collect();

        return view('jugadores.index', compact('equipos', 'equipo', 'jugadores'));
    }

    /**
     * Muestra el formulario para registrar un jugador en un equipo.
     */
    public function create(Equipo $equipo)
    {
        return view('jugadores.formulario', ['equipo' => $equipo, 'jugador' => new Jugador()]);
    }

    /**
     * Valida los datos y guarda el jugador en el equipo.
     */
    public function store(Request $request, Equipo $equipo)
    {
        $equipo->jugadores()->create($this->validar($request, $equipo));

        return redirect()
            ->route('jugadores.index', ['equipo_id' => $equipo->id])
            ->with('exito', 'Jugador registrado correctamente.');
    }

    /**
     * Muestra el formulario con los datos del jugador para modificarlos.
     */
    public function edit(Jugador $jugador)
    {
        return view('jugadores.formulario', ['equipo' => $jugador->equipo, 'jugador' => $jugador]);
    }

    /**
     * Valida los datos y actualiza el jugador.
     */
    public function update(Request $request, Jugador $jugador)
    {
        $jugador->update($this->validar($request, $jugador->equipo, $jugador));

        return redirect()
            ->route('jugadores.index', ['equipo_id' => $jugador->equipo_id])
            ->with('exito', 'Jugador actualizado correctamente.');
    }

        /**
     * Elimina el jugador.
     */
    public function destroy(Jugador $jugador)
    {
        $equipoId = $jugador->equipo_id;

        $jugador->delete();

        return redirect()
            ->route('jugadores.index', ['equipo_id' => $equipoId])
            ->with('exito', 'Jugador eliminado correctamente.');
    }

    /**
     * Reglas de validación compartidas por crear y editar.
     */
    private function validar(Request $request, Equipo $equipo, ?Jugador $jugador = null): array
    {
        return $request->validate([
            'nombre'      => ['required', 'string', 'max:100'],
            // El dorsal debe ser único solo dentro del mismo equipo
            'dorsal'      => ['required', 'integer', 'between:0,99',
                Rule::unique('jugadores', 'dorsal')->where('equipo_id', $equipo->id)->ignore($jugador?->id)],
            'posicion'    => ['required', Rule::in(Jugador::POSICIONES)],
            'estatura_cm' => ['nullable', 'integer', 'between:120,250'],
        ], [
            'nombre.required'      => 'El nombre del jugador es obligatorio.',
            'dorsal.required'      => 'El dorsal es obligatorio.',
            'dorsal.integer'       => 'El dorsal debe ser un número.',
            'dorsal.between'       => 'El dorsal debe estar entre 0 y 99.',
            'dorsal.unique'        => 'Ese dorsal ya lo usa otro jugador del equipo.',
            'posicion.required'    => 'La posición es obligatoria.',
            'posicion.in'          => 'Elige una posición de la lista.',
            'estatura_cm.integer'  => 'La estatura debe ser un número.',
            'estatura_cm.between'  => 'La estatura debe estar entre 120 y 250 cm.',
        ]);
    }
}