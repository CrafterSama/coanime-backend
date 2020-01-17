@inject('helper', 'App\Helper')
@inject('carbon', 'Carbon\Carbon')

{{-- Head Info --}}

@section('title', 'Articulos - ' . $post->categories->name . ' - ' . $post->title)

@section('description', $helper->excerpt($helper->textWithoutImage(strip_tags($post->content))) . '...')

@section('og_type')
    <meta property="og:type" content="article" />
@endsection

@section('twitter-image', $post->image)

@section('tags')
    <meta property="article:publisher" content="http://www.facebook.com/Coanime">
    @foreach($post->tags as $t)
        <meta property="article:tag" content="{{ $t->name }}" />
    @endforeach
@endsection

@section('section')
    <meta property="article:section" content="{{ $post->categories->name }}" />
@endsection

@section('time')
    @if ($post->postponed_to !== null)
        <meta property="article:published_time" content="{{ $post->postponed_to->format('c') }}" />
    @else
        <meta property="article:published_time" content="{{ $post->created_at->format('c') }}" />
    @endif
@endsection

{{-- /End Head Info --}}

@extends('layouts.app')
@section('content')

<post post-slug="{{ $post->slug }}"></post>

@endsection
