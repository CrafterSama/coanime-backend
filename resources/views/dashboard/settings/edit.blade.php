@inject('helper', 'App\Helper')
@inject('carbon', 'Carbon\Carbon')

@extends('layouts.app')

@section('title', 'Lista de Posts')

@section('content')

@include('dashboard.partials.top-title')

@include('dashboard.partials.leftbar')
	
<h2></h2>

@endsection