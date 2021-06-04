@inject('helper', 'App\Helper')

@section('title', 'Titulos')

@extends('layouts.app')

@section('content')
<div class="lists col-md-12">
    <h3 class="other-info-title col-md-12">Capitulos Online en los ultimos 7 días - Intercambios Legion Anime App</h3>
    <div class="clearfix"></div>
    <div class="calendar-list orange">
        <div class="app-link col-md-12">
            <span class="pull-right">
                <a href="https://play.google.com/store/apps/details?id=aplicaciones.paleta.legionanime&hl=es">Ver en la APP de Legion Anime <i class="fa fa-play"></i></a>
            </span>
        </div>
        <ul class="col-md-12">
            @if(!empty($legion))
                @foreach(collect($legion['response']) as $leg)
                <li class="col-xs-6 col-sm-6 col-md-3">
                    <i class="fa fa-film"></i>&nbsp;<a href="{{ route('titles') }}/tv/{{str_slug($leg['name'])}}">Ep. {{ $leg['episode'] . ' - ' . $leg['name'] }} <span class="text-italic">(TV)</span></a>
                    <br>
                    <small>Fecha: {{ $leg['date'] }}</small>
                </li>
                @endforeach
            @else
                No se puede acceder al Servidor de Intercambios
            @endif
        </ul>
        <div class="clearfix"></div>
    </div>
</div>
@endsection