@inject('helper', 'App\Helper')

@extends('layouts.app')

@section('title', 'Coanime.net - Titulos')
@section('description', 'Sección general de la enciclopedia, puedes encontrar tÃ­tulos de Tv, Manga, Ovas, Novelas ligeras, Live Action, Video juegos, Doramas y más.')
@section('twitter-image', 'https://coanime.net/images/ecma-logo.png')


@section('content')

<ecma-titles section="{{ Request::segment(2) }}" type-slug="{{  Request::segment(2) === 'titulos' ? Request::segment(3) : '' }}" genre-slug="{{ Request::segment(2) === 'generos' ? Request::segment(3) : '' }}" ></ecma-titles>

@endsection
