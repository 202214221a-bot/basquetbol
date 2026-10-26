<?php

namespace App\Http\Controllers;

use App\Models\Equipo;
use App\Models\Partido;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class PartidoController extends Controller
{
    /**
     * Muestra la lista de partidos, del más reciente al más antiguo.
     */
    public function index()
    {
        $partidos = Partido::with(['equipoLocal', 'equipoVisitante'])
            ->orderByDesc('fecha_hora')
            ->get();

        return view('partidos.index', compact('partidos'));
    }

    /**
     * Muestra el formulario para registrar un partido nuevo.
     */
    public function create()
    {
        // Un partido necesita dos equipos distintos
        if (Equipo::count() < 2) {
            return redirect()
                ->route('partidos.index')
                ->withErrors(['equipos' => 'Necesitas al menos 2 equipos registrados para crear un partido.']);
        }

        return view('partidos.formulario', [
            'partido' => new Partido(['estado' => 'programado']),
            'equipos' => Equipo::orderBy('nombre')->get(),
        ]);
    }

    /**
     * Valida los datos y guarda el partido nuevo.
     */
    public function store(Request $request)
    {
        Partido::create($this->validar($request));

        return redirect()->route('partidos.index')->with('exito', 'Partido registrado correctamente.');
    }

    /**
     * Muestra el formulario con los datos del partido para modificarlos.
     */
    public function edit(Partido $partido)
    {
        return view('partidos.formulario', [
            'partido' => $partido,
            'equipos' => Equipo::orderBy('nombre')->get(),
        ]);
    }

    /**
     * Valida los datos y actualiza el partido.
     */
    public function update(Request $request, Partido $partido)
    {
        $partido->update($this->validar($request));

        return redirect()->route('partidos.index')->with('exito', 'Partido actualizado correctamente.');
    }

        /**
     * Elimina el partido.
     */
    public function destroy(Partido $partido)
    {
        $partido->delete();

        return redirect()->route('partidos.index')->with('exito', 'Partido eliminado correctamente.');
    }

    /**
     * Reglas de validación compartidas por crear y editar.
     */
    private function validar(Request $request): array
    {
        $datos = $request->validate([
            'equipo_local_id'     => ['required', 'exists:equipos,id'],
            'equipo_visitante_id' => ['required', 'exists:equipos,id', 'different:equipo_local_id'],
            'fecha_hora'          => ['required', 'date'],
            'estado'              => ['required', 'in:programado,finalizado'],
            'puntos_local'        => ['nullable', 'required_if:estado,finalizado', 'integer', 'min:0'],
            'puntos_visitante'    => ['nullable', 'required_if:estado,finalizado', 'integer', 'min:0'],
        ], [
            'equipo_local_id.required'      => 'Elige el equipo local.',
            'equipo_visitante_id.required'  => 'Elige el equipo visitante.',
            'equipo_visitante_id.different' => 'Un equipo no puede jugar contra sí mismo.',
            'fecha_hora.required'           => 'La fecha y la hora son obligatorias.',
            'fecha_hora.date'               => 'Escribe una fecha y hora válidas.',
            'puntos_local.required_if'      => 'Escribe los puntos del equipo local.',
            'puntos_visitante.required_if'  => 'Escribe los puntos del equipo visitante.',
            'puntos_local.integer'          => 'Los puntos deben ser un número entero.',
            'puntos_visitante.integer'      => 'Los puntos deben ser un número entero.',
            'puntos_local.min'              => 'Los puntos no pueden ser negativos.',
            'puntos_visitante.min'          => 'Los puntos no pueden ser negativos.',
        ]);

        if ($datos['estado'] === 'finalizado') {
            // En el básquetbol no existen los empates
            if ((int) $datos['puntos_local'] === (int) $datos['puntos_visitante']) {
                throw ValidationException::withMessages([
                    'puntos_local' => 'En básquetbol no hay empates: los puntos deben ser distintos.',
                ]);
            }
        } else {
            // Un partido programado todavía no tiene puntaje
            $datos['puntos_local'] = null;
            $datos['puntos_visitante'] = null;
        }

        return $datos;
    }
}