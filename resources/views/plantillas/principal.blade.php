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