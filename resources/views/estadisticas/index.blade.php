@extends('plantillas.principal')

@section('contenido')
<h2>Tabla de posiciones</h2>

<table>
  <tr>
    <th>#</th>
    <th>Equipo</th>
    <th>PJ</th>
    <th>G</th>
    <th>P</th>
    <th>PF</th>
    <th>PC</th>
    <th>Dif</th>
    <th>Pts</th>
  </tr>

  @forelse ($posiciones as $lugar => $fila)
  <tr>
    <td>{{ $lugar + 1 }}</td>
    <td>{{ $fila->nombre }}</td>
    <td>{{ $fila->jugados }}</td>
    <td>{{ $fila->ganados }}</td>
    <td>{{ $fila->perdidos }}</td>
    <td>{{ $fila->a_favor }}</td>
    <td>{{ $fila->en_contra }}</td>
    <td>{{ $fila->diferencia > 0 ? '+' : '' }}{{ $fila->diferencia }}</td>
    <td><strong>{{ $fila->puntos_liga }}</strong></td>
  </tr>
  @empty
  <tr>
    <td colspan="9">Registra equipos y partidos para ver las estadísticas.</td>
  </tr>
  @endforelse
</table>

<small>
  PJ: partidos jugados · G: ganados · P: perdidos · PF: puntos a favor · PC: puntos en contra ·
  Dif: diferencia de puntos · Pts: 2 por victoria y 1 por derrota.
</small>
@endsection