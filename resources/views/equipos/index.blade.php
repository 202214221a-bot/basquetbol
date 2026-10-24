@extends('plantillas.principal')

@section('contenido')
<div class="barra">
  <h2>Equipos</h2>
  <a class="boton" href="{{ route('equipos.create') }}">+ Nuevo equipo</a>
</div>

<table>
  <tr>
    <th>Nombre</th>
    <th>Ciudad</th>
    <th>Año de fundación</th>
  </tr>

  @forelse ($equipos as $equipo)
  <tr>
    <td>{{ $equipo->nombre }}</td>
    <td>{{ $equipo->ciudad }}</td>
    <td>{{ $equipo->anio_fundacion }}</td>
  </tr>
  @empty
  <tr>
    <td colspan="3">Aún no hay equipos registrados.</td>
  </tr>
  @endforelse
</table>
@endsection