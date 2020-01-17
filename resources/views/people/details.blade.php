@inject('helper', 'App\Helper')

@section('title', 'Coanime.net - Personas - ' . $people->name )
@section('description', str_limit(strip_tags($people->bio), 140))
@if(empty($people->image))
    @section('twitter-image', 'https://coanime.net//images/no_image.jpg')
@else
    @section('twitter-image', 'https://coanime.net/images/encyclopedia/people/' . $people->image)
@endif

@extends('layouts.app')

@section('content')

<ecma-person slug="{{ $people->slug }}"></ecma-person>

@endsection
