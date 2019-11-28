@inject('helper', 'App\Helper')

@section('title', 'Lista de Tags')
@section('description', 'Secciรณn en la que encontrarรกs la lista de Tags relacionados a las noticias.')

@extends('layouts.app')

@section('content')
<div class="lists col-md-12">
    <h3 class="other-info-title col-md-12">Lista de Tags</h3>
    <div class="clearfix"></div>
    <div class="genre-list orange">
        <ul>
            @foreach($tags as $t)
            <li class="col-xs-6 col-sm-6 col-md-3 col-full-xs"><a class="orange" href="{{ route('tags') }}/{{ $t->slug }}">{{ $t->name }} ({{ $t->posts_count }})</a></li>
            @endforeach
        </ul>
        <div class="clearfix"></div>
    </div>
    <div class="pagination col-md-12 text-center">
        {{ $tags->appends(request()->all())->links() }}
    </div>
</div>
@endsection
