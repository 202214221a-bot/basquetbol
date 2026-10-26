@extends('plantillas.principal')

@section('contenido')
<div class="barra">
  <h2>Partidos</h2>
  <a class="boton" href="{{ route('partidos.create') }}">+ Nuevo partido</a>
</div>

<table>
  <tr>
    <th>Fecha</th>
    <th>Local</th>
    <th>Resultado</th>
    <th>Visitante</th>
    <th>Estado</th>
    <th></th>
  </tr>

  @forelse ($partidos as $partido)
  <tr>
    <td>{{ $partido->fecha_hora->format('d/m/Y H:i') }}</td>
    <td>{{ $partido->equipoLocal->nombre }}</td>
    <td class="puntaje">
      {{ $partido->estaFinalizado() ? $partido->puntos_local . ' - ' . $partido->puntos_visitante : 'vs' }}
    </td>
    <td>{{ $partido->equipoVisitante->nombre }}</td>
    <td>{{ $partido->estaFinalizado() ? 'Finalizado' : 'Programado' }}</td>
    <td class="acciones">
      <a href="{{ route('partidos.edit', $partido) }}">Editar</a>
    </td>
  </tr>
  @empty
  <tr>
    <td colspan="6">Aún no hay partidos registrados.</td>
  </tr>
  @endforelse
</table>
@endsection