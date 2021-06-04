@inject('helper', 'App\Helper')
@inject('carbon', 'Carbon\Carbon')

@extends('layouts.dashboard')

@section('title', 'Lista de Posts')

@section('content')

    @include('dashboard.partials.top-title')

    @include('dashboard.partials.leftbar')

    <div class="col-md-10">

    </div>

@endsection
