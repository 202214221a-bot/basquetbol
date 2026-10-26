@extends('plantillas.principal')

@section('contenido')
<div class="barra">
  <h2>Partidos</h2>
</div>

<table>
  <tr>
    <th>Fecha</th>
    <th>Local</th>
    <th>Resultado</th>
    <th>Visitante</th>
    <th>Estado</th>
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
  </tr>
  @empty
  <tr>
    <td colspan="5">Aún no hay partidos registrados.</td>
  </tr>
  @endforelse
</table>
@endsection