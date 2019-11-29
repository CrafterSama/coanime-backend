@inject('helper', 'App\Helper')

@section('title', 'Lista de Generos')
@section('description', 'Sección en la que encontrarás la lista de géneros como: shoujo, shounen, seinen, gore, entre otros.')

@extends('layouts.app')

@section('content')
<div class="lists col-md-12">
    <h3 class="other-info-title col-md-12">Lista de Generos</h3>
    <div class="clearfix"></div>
    <div class="genre-list orange">
        <ul>
            @foreach($genre as $g)
            <li class="col-xs-6 col-sm-6 col-md-3 col-full-xs"><a class="orange" href="{{ route('genres') }}/{{ $g->slug }}">{{ $g->name }} ({{ $g->titles_count }})</a></li>
            @endforeach
        </ul>
        <div class="clearfix"></div>
    </div>
</div>
@endsection
