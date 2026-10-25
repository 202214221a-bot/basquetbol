@extends('plantillas.principal')

@section('contenido')
<section class="tarjeta angosta">
  <h2>{{ $jugador->exists ? 'Editar jugador' : 'Nuevo jugador' }} — {{ $equipo->nombre }}</h2>

  <form method="POST"
        action="{{ $jugador->exists ? route('jugadores.update', $jugador) : route('jugadores.store', $equipo) }}">
    @csrf
    @if ($jugador->exists)
      @method('PUT')
    @endif

    <label>Nombre
      <input type="text" name="nombre" value="{{ old('nombre', $jugador->nombre) }}" required>
    </label>

    <label>Dorsal (0 a 99)
      <input type="number" name="dorsal" min="0" max="99" value="{{ old('dorsal', $jugador->dorsal) }}" required>
    </label>

    <label>Posición
      <select name="posicion" required>
        @foreach (\App\Models\Jugador::POSICIONES as $posicion)
          <option value="{{ $posicion }}" @selected(old('posicion', $jugador->posicion) === $posicion)>{{ $posicion }}</option>
        @endforeach
      </select>
    </label>

    <label>Estatura en cm (opcional)
      <input type="number" name="estatura_cm" value="{{ old('estatura_cm', $jugador->estatura_cm) }}">
    </label>

    <button type="submit">Guardar</button>
    <a href="{{ route('jugadores.index', ['equipo_id' => $equipo->id]) }}">Cancelar</a>
  </form>
</section>
@endsection