@extends('plantillas.principal')

@section('contenido')
<section class="tarjeta">
  <h2>Bienvenido, {{ auth()->user()->name }}</h2>
  <p>Desde aquí podrás administrar los equipos, jugadores y partidos de la liga.</p>
</section>
@endsection