@extends('plantillas.principal')

@section('contenido')
<section class="tarjeta angosta">
  <h2>Nuevo equipo</h2>

  <form method="POST" action="{{ route('equipos.store') }}">
    @csrf

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