@inject('helper', 'App\Helper')

{{-- Head Info --}}

@if(Request::path() != '/')
    @section('title', 'Noticias Recientes')
    @section('description', 'Noticias más recientes de anime, manga, vídeo juegos, doramas y cultura del medio oriente asiático.')
@else
    @section('title', 'Noticias e Información sobre Cultura Otaku, Manga y Anime')
    @section('description', 'Encuentra las noticias más recientes de anime, manga, video juegos y más. Puedes encontrar información  de eventos realizados en Hispanoamérica y de las series, manga, seiyus o compañías encargadas en nuestra Enciclopedia.')
@endif

@section('og_type')
    <meta property="og:type" content="website" />
@endsection
@section('twitter-image', 'https://coanime.net/images/coanime.twitter.jpg')

{{-- /End Head Info --}}

@extends('layouts.app')

@section('content')
<div class="post-content col-xs-12 col-sm-12 col-md-12">
	<div class="posts-wrapper col-md-12">
		<div class="grid">
			@forelse($posts as $post)
			<div class="grid-item">
				<!-- div class="row before-box" -->
					<div class="post">
						<div class="post-header">
							<div class="post-top-image">
								<a href="/posts/{{ $post->slug }}">
									@if(!empty($post->image))
										{{-- <img class="article-image" src="{!! str_replace('1920','320',asset('images/posts/thumbnails/thumb-' . $post->image)) !!}" alt="{{ $post->title }} - Coanime.net" /> --}}
										<img class="article-image" src="{!! str_replace('1920','480', $post->image) !!}" alt="{{ $post->title }} - Coanime.net" />
									@else
										<img src="{{$helper->img_post($post->content)}}" alt="{{ $post->title }} - Coanime.net">
									@endif
								</a>
							</div>
							<a href="/categorias/{{ $post->categories->slug }}"><span class="post-category {{ $post->categories->slug }}">{{ $post->categories->name }}</span></a>
							<h2 class="post-title"><a href="/posts/{{ $post->slug }}">{{ $post->title }}</a></h2>
                            <div class="post-header-details">
                                <span class="post-author"><a href="{{ route('profile',$post->users->slug) }}">{{ $post->users->name }}</a></span>
                                @if ($post->postponed_to == $post->created_at || is_null($post->postponed_to))
                                @if (is_null($post->created_at))
                                <time class="post-date timeago" datetime="{{$carbon->parse($post->post_created_at)->format('Y-m-d H:i:s')}}" title=""></time>
                                @else
                                <time class="post-date timeago" datetime="{{$carbon->parse($post->created_at)->format('Y-m-d H:i:s')}}" title=""></time>
                                @endif
                                @else
                                <time class="post-date timeago" datetime="{{$carbon->parse($post->postponed_to)->format('Y-m-d H:i:s')}}" title=""></time>
                                @endif
                            </div>
							@if(Auth::guest() == false)
								@if(Auth::user()->isAdmin() || Auth::user()->isMod())
								<span class="post-edit-button">
									<a href="/dashboard/posts/{{$post->id}}/edit" class="btn btn-info btn-sm" data-container="body" data-toggle="tooltip" data-placement="top" title="Editar"><i class="fas fa-pen"></i></a>
								</span>
								@endif
							@endif
						</div>
						<div class="post-body text-justify">
							{!! str_limit(strip_tags($post->content, 300)) !!} <a href="{{route('blog')}}/{{$post->slug}}">Leer Mas</a>
						</div>
					</div>
				<!-- /div -->
            </div>
			@empty
			<div class="grid-item">
                <div class="post">
                    <p>Sin Resultados</p>
				</div>
			</div>
            @endforelse
		</div>
	</div>
	<div class="pagination col-md-12 text-center">
		{{ $posts->appends(request()->all())->links() }}
	</div>
</div>
@endsection
