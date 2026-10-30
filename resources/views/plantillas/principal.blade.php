<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Liga de Básquetbol</title>
  <link rel="icon" href="data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 100 100%22><text y=%22.9em%22 font-size=%2290%22>🏀</text></svg>">
  <link rel="stylesheet" href="{{ asset('css/estilos.css') }}">
</head>
<body>
  <header>
    <a class="marca" href="{{ route('inicio') }}"><span class="pelota">🏀</span> Liga de Básquetbol</a>

    @auth
    <nav>
      <a href="{{ route('inicio') }}" class="{{ request()->routeIs('inicio') ? 'activo' : '' }}">Inicio</a>
      <a href="{{ route('equipos.index') }}" class="{{ request()->routeIs('equipos.*') ? 'activo' : '' }}">Equipos</a>
      <a href="{{ route('jugadores.index') }}" class="{{ request()->routeIs('jugadores.*') ? 'activo' : '' }}">Jugadores</a>
      <a href="{{ route('partidos.index') }}" class="{{ request()->routeIs('partidos.*') ? 'activo' : '' }}">Partidos</a>
      <a href="{{ route('estadisticas.index') }}" class="{{ request()->routeIs('estadisticas.*') ? 'activo' : '' }}">Estadísticas</a>

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

  <footer>Liga de Básquetbol · Práctica calificada · Laravel y MySQL</footer>
</body>
</html>