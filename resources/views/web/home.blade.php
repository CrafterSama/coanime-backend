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
	<div class="hidden-md hidden-lg">
		@include('partials.searchbox')
	</div>
	@if(Request::path() == '/')
	<div class="posts-wrapper col-md-8">
	@else
	<div class="posts-wrapper col-md-12">
	@endif
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
	@if(Request::path() == '/')
	<div class="posts-sidebar hidden-xs hidden-sm col-md-4">
		@include('partials.searchbox')
		<h3 class="other-info-title col-md-12">Siguenos</h3>
		<div class="col-md-12 text-center">
			<div class="fb-like" data-href="https://www.facebook.com/Coanime/" data-layout="button_count" data-action="like" data-size="large" data-show-faces="false" data-share="false"></div>
			<a class="twitter-follow-button" href="https://twitter.com/coanime" data-show-screen-name="false" data-show-count="true" data-size="large">Follow @coanime</a> <script defer src="//platform.twitter.com/widgets.js" charset="utf-8"></script>
		</div>
		@if ($events->count() > 0)
		<h3 class="other-info-title col-md-12">Eventos del Mundo Hispano</h3>
		<div class="slider-events col-md-12">
			<div id="events-slider">
				@foreach($events->take(5) as $event)
				<a href="{{ route('events') }}/{{ $event->slug }}">
					<img data-u="image" class="home-event-image" src="../../images/events/{{$event->image}}" />
					<div class="home-event-title">{{ $event->name }}</div>
					<div class="home-event-place">{{ $event->city->name }}, {{ $event->country->name }}</div>
				</a>
				@endforeach
				<a href="#" class="slidesjs-previous slidesjs-navigation"><i class="fas fa-chevron-left"></i></a>
            	<a href="#" class="slidesjs-next slidesjs-navigation"><i class="fas fa-chevron-right"></i></a>
			</div>
			<div class="clearfix"></div>
		</div>
		@endif
		<div id="legion-anime"></div>
		<h3 class="other-info-title col-md-12">Ultimos titulos agregados</h3>
		<div class="text-justify col-md-12">
			<dd>
			@foreach( $titles->take(5) as $lt )
				<dl class="list">
					<i class="fas fa-tags"></i>&nbsp;
					<a href="{{ route('titles') }}/{{strtolower($lt->type->name)}}/{{$lt->slug}}">{{ $lt->name }} <span class="text-italic">({{ $lt->type->name }})</span></a>
					<br>
					<small>Agregado por: {{ $lt->users->name }}</small>
				</dl>
			@endforeach
			</dd>
		</div>
		<h3 class="other-info-title col-md-12">Ultimos personas agregadas</h3>
		<div class="text-justify col-md-12">
			<dd>
			@foreach( $people->take(5) as $p )
				<dl class="list">
					<i class="fas fa-users"></i>&nbsp;
					<a href="{{ route('people') }}/{{$p->slug}}">{{ $p->name }}</a>
					<br>
					<small>Agregado por: {{ $p->users->name }}</small>
				</dl>
			@endforeach
			</dd>
		</div>
		<h3 class="other-info-title col-md-12">Ultimas revistas agregadas</h3>
		<div class="text-justify col-md-12">
			<dd>
			@foreach( $magazine->take(5) as $m )
				<dl class="list">
					<i class="fas fa-book"></i>&nbsp;
					<a href="{{ route('magazine') }}/{{$m->slug}}">{{ $m->name }}</a>
					<br>
					<small>Agregado por: {{ $m->users->name }}</small>
				</dl>
			@endforeach
			</dd>
		</div>
		<h3 class="other-info-title col-md-12">Ultimas empresas agregadas</h3>
		<div class="text-justify col-md-12">
			<dd>
			@foreach( $companies->take(5) as $c )
				<dl class="list">
					<i class="fas fa-building"></i>&nbsp;
					<a href="{{ route('companies') }}/{{$c->slug}}">{{ $c->name }}</a>
					<br>
					<small>Agregado por: {{ $c->users->name }}</small>
				</dl>
			@endforeach
			</dd>
		</div>
		{{-- <h3 class="other-info-title col-md-12">Enciclopedia Info</h3>
						<p class="text-justify col-md-12">En nuestra enciclopedia actualmente contamos con: <span class="text-strong">{{ $titles->count() }}</span> titulos de manga y anime, <span class="text-strong">{{ $people->count() }}</span> personas que cuentan entre autores, directores, seiyuus, etc., <span class="text-strong">{{ $magazine->count() }}</span> revistas que tienen que ver con el mundillo y <span class="text-strong">{{ $companies->count() }}</span> Empresas, entre ellas Editoriales, productoras, televisoras, y un largo etc., queremos seguir creciendo y queremos hacerlo a diario, sabemos que podriamos lograrlo si todos los que nos involucremos con este proyecto pusieramos solo un grano de arena, así podriamos hacer nuestra enciclopedia mucho mas grande.</p> --}}
	</div>
	@endif
	<div class="pagination col-md-12 text-center">
		{{ $posts->appends(request()->all())->links() }}
	</div>
</div>
@endsection
