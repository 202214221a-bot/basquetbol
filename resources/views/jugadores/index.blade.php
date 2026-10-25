@extends('plantillas.principal')

@section('contenido')
<div class="barra">
  <h2>Jugadores</h2>
</div>

@if ($equipos->isEmpty())
  <p>Primero <a href="{{ route('equipos.create') }}">registra un equipo</a> para poder agregar jugadores.</p>
@else
  <form method="GET" action="{{ route('jugadores.index') }}" class="filtro">
    <label>Equipo
      <select name="equipo_id" onchange="this.form.submit()">
        @foreach ($equipos as $e)
          <option value="{{ $e->id }}" @selected($equipo && $e->id === $equipo->id)>{{ $e->nombre }}</option>
        @endforeach
      </select>
    </label>
  </form>

  <table>
    <tr>
      <th>#</th>
      <th>Nombre</th>
      <th>Posición</th>
      <th>Estatura</th>
    </tr>

    @forelse ($jugadores as $jugador)
    <tr>
      <td>{{ $jugador->dorsal }}</td>
      <td>{{ $jugador->nombre }}</td>
      <td>{{ $jugador->posicion }}</td>
      <td>{{ $jugador->estatura_cm ? $jugador->estatura_cm . ' cm' : '—' }}</td>
    </tr>
    @empty
    <tr>
      <td colspan="4">Este equipo todavía no tiene jugadores.</td>
    </tr>
    @endforelse
  </table>
@endif
@endsection