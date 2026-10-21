@extends('plantillas.principal')

@section('contenido')
<section class="tarjeta angosta">
  <h2>Crear cuenta</h2>

  <form method="POST" action="{{ url('/registro') }}">
    @csrf

    <label>Nombre
      <input type="text" name="name" value="{{ old('name') }}" required>
    </label>

    <label>Correo
      <input type="email" name="email" value="{{ old('email') }}" required>
    </label>

    <label>Contraseña
      <input type="password" name="password" minlength="6" required>
    </label>

    <label>Repite la contraseña
      <input type="password" name="password_confirmation" required>
    </label>

    <button type="submit">Registrarme</button>
  </form>
</section>
@endsection