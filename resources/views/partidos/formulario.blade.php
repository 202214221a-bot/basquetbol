@extends('plantillas.principal')

@section('contenido')
<section class="tarjeta angosta">
  <h2>{{ $partido->exists ? 'Editar partido' : 'Nuevo partido' }}</h2>

  <form method="POST" action="{{ $partido->exists ? route('partidos.update', $partido) : route('partidos.store') }}">
    @csrf
    @if ($partido->exists)
      @method('PUT')
    @endif

    <label>Equipo local
      <select name="equipo_local_id" required>
        <option value="">— Elige un equipo —</option>
        @foreach ($equipos as $equipo)
          <option value="{{ $equipo->id }}" @selected((int) old('equipo_local_id', $partido->equipo_local_id) === $equipo->id)>{{ $equipo->nombre }}</option>
        @endforeach
      </select>
    </label>

    <label>Equipo visitante
      <select name="equipo_visitante_id" required>
        <option value="">— Elige un equipo —</option>
        @foreach ($equipos as $equipo)
          <option value="{{ $equipo->id }}" @selected((int) old('equipo_visitante_id', $partido->equipo_visitante_id) === $equipo->id)>{{ $equipo->nombre }}</option>
        @endforeach
      </select>
    </label>

    <label>Fecha y hora
      <input type="datetime-local" name="fecha_hora"
             value="{{ old('fecha_hora', ($partido->fecha_hora ?? now())->format('Y-m-d\TH:i')) }}" required>
    </label>

    <label>Estado
      <select name="estado">
        <option value="programado" @selected(old('estado', $partido->estado) === 'programado')>Programado</option>
        <option value="finalizado" @selected(old('estado', $partido->estado) === 'finalizado')>Finalizado</option>
      </select>
    </label>

    <div class="fila">
      <label>Puntos del local
        <input type="number" min="0" name="puntos_local" value="{{ old('puntos_local', $partido->puntos_local) }}">
      </label>
      <label>Puntos del visitante
        <input type="number" min="0" name="puntos_visitante" value="{{ old('puntos_visitante', $partido->puntos_visitante) }}">
      </label>
    </div>

    <small>Los puntos solo se guardan si el estado es «Finalizado».</small><br><br>

    <button type="submit">Guardar</button>
    <a href="{{ route('partidos.index') }}">Cancelar</a>
  </form>
</section>
@endsection