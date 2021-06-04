@inject('helper', 'App\Helper')
@inject('carbon', 'Carbon\Carbon')

@section('title', $post->categories->name.' - '.$post->title )
@section('description', $helper->excerpt($helper->textWithoutImage(strip_tags($post->content))) . '...')
@section('twitter-image', 'https://coanime.net/images/posts/'. $post->image)

@extends('layouts.app')

@section('content')
<div class="page post-content col-md-12">
	<div class="posts-wrapper col-md-12">
	 	<div class="post-inside">
            <div class="post-top-image">
                @if($post->image)
                    <img src="{!! asset('images/posts/'. $post->image) !!}" alt="{{ $post->title }} - Coanime">
                @else
                    <img src="{{$helper->img_post($post->content)}}" alt="{{ $post->title }} - Coanime">
                @endif
                @if(Auth::guest() == false)
					@if(Auth::user()->isAdmin())
					<span><a href="/dashboard/posts/{{$post->id}}/edit" class="btn btn-info btn-sm" data-container="body" data-toggle="tooltip" data-placement="top" title="Editar"><i class="fa fa-pencil"></i></a></span>
					@endif
				@endif
            </div>
		  	<div class="post-details">
		 		<h2 class ="post-title-details">{{ $post->title }}</h2>
			</div>
			<div class="post-body text-justify">
				{!! $post->content !!}
				{{--$post->titles->count()--}}
			</div>
			<div class="post-footer col-md-12">
		 		<div class="row options-toolbar col-md-12 text-left">
					<a href="/" class="btn btn-warning"><i class="fa fa-chevron-left"></i> Volver</a>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
