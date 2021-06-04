@inject('helper', 'App\Helper')

@section('title', 'Enciclopedia - Personas')
@section('description', 'Sección donde encontrarás información sobre Autores, Directores, Seiyuus, Mangakas y personalidades del mundo del anime, manga o videojuegos.' )
@section('twitter-image', 'https://coanime.net/images/ecma-logo.png')

@extends('layouts.app')

@section('content')

<ecma-people section="{{ Request::segment(2) }}"></ecma-people>

@endsection
