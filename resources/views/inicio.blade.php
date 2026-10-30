@extends('plantillas.principal')

@section('contenido')
@php
  $hora = now()->hour;
  $saludo = $hora < 12 ? 'Buenos días' : ($hora < 19 ? 'Buenas tardes' : 'Buenas noches');
  $nombre = explode(' ', trim(auth()->user()->name))[0];
@endphp

<div class="portada">
  <h2>{{ $saludo }}, {{ $nombre }} 👋</h2>
  <p class="fecha-hoy">{{ ucfirst(now()->locale('es')->isoFormat('dddd D [de] MMMM [de] YYYY')) }}</p>
  <p>Administra los equipos, los jugadores y los partidos de tu liga desde un solo lugar.</p>

  <div class="accesos">
    <a class="boton claro" href="{{ route('partidos.create') }}">+ Programar partido</a>
    <a class="boton claro" href="{{ route('equipos.create') }}">+ Nuevo equipo</a>
  </div>
</div>

<div class="modulos">
  <a class="modulo" href="{{ route('equipos.index') }}">
    <div class="icono">🏟️</div>
    <h3>Equipos <span class="contador">{{ $resumen['equipos'] }}</span></h3>
    <p>Registra, edita y elimina los equipos de la liga.</p>
  </a>

  <a class="modulo" href="{{ route('jugadores.index') }}">
    <div class="icono">👥</div>
    <h3>Jugadores <span class="contador">{{ $resumen['jugadores'] }}</span></h3>
    <p>Administra la plantilla de cada equipo.</p>
  </a>

  <a class="modulo" href="{{ route('partidos.index') }}">
    <div class="icono">📅</div>
    <h3>Partidos <span class="contador">{{ $resumen['jugados'] + $resumen['programados'] }}</span></h3>
    <p>{{ $resumen['jugados'] }} jugados y {{ $resumen['programados'] }} programados.</p>
  </a>

  <a class="modulo" href="{{ route('estadisticas.index') }}">
    <div class="icono">📊</div>
    <h3>Estadísticas</h3>
    <p>Consulta la tabla de posiciones y los últimos resultados.</p>
  </a>
</div>

<div class="dos-columnas">
  <div class="tarjeta lider-card">
    <h3 class="titulo-panel">Líder de la liga</h3>

    @if ($lider && $lider->jugados > 0)
      <div class="trofeo">🏆</div>
      <div class="lider-nombre">{{ $lider->nombre }}</div>
      <div class="lider-puntos">{{ $lider->puntos_liga }} <small>puntos</small></div>
      <div class="lider-detalle">
        {{ $lider->ganados }} ganados · {{ $lider->perdidos }} perdidos ·
        dif.
        <span class="{{ $lider->diferencia >= 0 ? 'positivo' : 'negativo' }}">
          {{ $lider->diferencia > 0 ? '+' : '' }}{{ $lider->diferencia }}
        </span>
      </div>
      <a class="boton" href="{{ route('estadisticas.index') }}">Ver tabla completa</a>
    @else
      <div class="vacio">
        <div class="trofeo">🏆</div>
        <p>Todavía no hay resultados. Cuando se juegue el primer partido, aquí aparecerá el líder.</p>
        <a class="boton" href="{{ route('partidos.create') }}">Registrar un partido</a>
      </div>
    @endif
  </div>

  <div class="tarjeta">
    <h3 class="titulo-panel">Próximos partidos</h3>

    @forelse ($proximos as $partido)
      @if ($loop->first)
        <ul class="lista-partidos">
      @endif

      <li>
        <div class="fecha-bloque">
          <strong>{{ $partido->fecha_hora->format('d') }}</strong>
          <span>{{ $partido->fecha_hora->locale('es')->isoFormat('MMM') }}</span>
        </div>
        <div class="duelo">
          <div class="equipos-duelo">
            {{ $partido->equipoLocal->nombre }} <em>vs</em> {{ $partido->equipoVisitante->nombre }}
          </div>
          <small>{{ $partido->fecha_hora->format('H:i') }} h</small>
        </div>
      </li>

      @if ($loop->last)
        </ul>
      @endif
    @empty
      <div class="vacio">
        <p>No hay partidos programados.</p>
        <a class="boton" href="{{ route('partidos.create') }}">Programar un partido</a>
      </div>
    @endforelse
  </div>
</div>
@endsection