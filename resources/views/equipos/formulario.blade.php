@extends('plantillas.principal')

@section('contenido')
<section class="tarjeta angosta">
  <h2>{{ $equipo->exists ? 'Editar equipo' : 'Nuevo equipo' }}</h2>

  <form method="POST" action="{{ $equipo->exists ? route('equipos.update', $equipo) : route('equipos.store') }}">
    @csrf
    @if ($equipo->exists)
      @method('PUT')
    @endif

    <label>Nombre
      <input type="text" name="nombre" value="{{ old('nombre', $equipo->nombre) }}" required>
    </label>

    <label>Ciudad
      <input type="text" name="ciudad" value="{{ old('ciudad', $equipo->ciudad) }}" required>
    </label>

    <label>Año de fundación (opcional)
      <input type="number" name="anio_fundacion" value="{{ old('anio_fundacion', $equipo->anio_fundacion) }}">
    </label>

    <button type="submit">Guardar</button>
    <a href="{{ route('equipos.index') }}">Cancelar</a>
  </form>
</section>
@endsection