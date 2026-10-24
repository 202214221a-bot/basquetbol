<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Liga de Básquetbol</title>
  <link rel="stylesheet" href="{{ asset('css/estilos.css') }}">
</head>
<body>
    <header>
    <h1>🏀 Liga de Básquetbol</h1>

    @auth
    <nav>
      <a href="{{ route('inicio') }}">Inicio</a>
            <a href="{{ route('equipos.index') }}">Equipos</a>

      <form method="POST" action="{{ route('salir') }}" class="en-linea">
        @csrf
        <button type="submit" class="enlace">{{ auth()->user()->name }} · Salir</button>
      </form>
    </nav>
    @endauth
  </header>

  <main>
    @if (session('exito'))
      <div class="mensaje exito">{{ session('exito') }}</div>
    @endif

    @foreach ($errors->all() as $error)
      <div class="mensaje error">{{ $error }}</div>
    @endforeach

    @yield('contenido')
  </main>
</body>
</html>