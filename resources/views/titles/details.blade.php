@inject('helper', 'App\Helper')
@inject('carbon', 'Carbon\carbon')

@section('title', 'Enciclopedia - ' . $title->type->name . ' - ' . $title->name )
@section('description', str_limit(strip_tags($title->sinopsis), 170))
@if(empty($title->images->name))
    @section('twitter-image', 'https://coanime.net/images/no_image.jpg')
@else
    @section('twitter-image', $title->images->name)
@endif

@extends('layouts.app')

@section('content')

<ecma-title slug="{{ $title->slug }}" type="{{ $title->type->slug }}"></ecma-title>
@endsection
