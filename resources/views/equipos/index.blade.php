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
    <th></th>
  </tr>

  @forelse ($equipos as $equipo)
  <tr>
    <td>{{ $equipo->nombre }}</td>
    <td>{{ $equipo->ciudad }}</td>
    <td>{{ $equipo->anio_fundacion }}</td>
    <td class="acciones">
      <a href="{{ route('equipos.edit', $equipo) }}">Editar</a>
      <form action="{{ route('equipos.destroy', $equipo) }}" method="POST" style="display: inline;">
        @csrf
        @method('DELETE')
        <button type="submit" onclick="return confirm('¿Estás seguro de que quieres eliminar este equipo?')">Eliminar</button>
      </form>
    </td>
  </tr>
  @empty
  <tr>
    <td colspan="4">Aún no hay equipos registrados.</td>
  </tr>
  @endforelse
</table>

@endsection