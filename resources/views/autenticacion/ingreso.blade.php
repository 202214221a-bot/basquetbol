@extends('plantillas.principal')

@section('contenido')
<section class="tarjeta angosta">
  <h2>Iniciar sesión</h2>

  <form method="POST" action="{{ url('/ingresar') }}">
    @csrf

    <label>Correo
      <input type="email" name="email" value="{{ old('email') }}" required>
    </label>

    <label>Contraseña
      <input type="password" name="password" required>
    </label>

    <button type="submit">Ingresar</button>
  </form>

  <p>¿No tienes cuenta? <a href="{{ route('registro') }}">Regístrate</a></p>
</section>
@endsection