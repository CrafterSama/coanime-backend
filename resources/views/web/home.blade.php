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
{{-- Relavants Articles in Slide Carousel --}}
<div class="relevants-box">
    <div id="carouselExampleCaptions" class="carousel slide carousel-fade" data-ride="carousel">
        <ol class="carousel-indicators">
            <li data-target="#carouselExampleCaptions" data-slide-to="0" class="active"></li>
            <li data-target="#carouselExampleCaptions" data-slide-to="1"></li>
            <li data-target="#carouselExampleCaptions" data-slide-to="2"></li>
        </ol>
        <div class="carousel-inner">
            @foreach($relevants as $r)
                <div class="carousel-item @if ($loop->first) active @endif">
                    <figure class="carousel-image-box">
                        <img src="{{ $r->image }}" class="d-block" alt="{{ $r->title }}">
                    </figure>
                    <div class="item__overlayer"></div>
                    <div class="carousel-caption d-xs-block">
                        <h3 class="section-title">Notas Destacadas</h3>
                        <h2><a href="/posts/{{ $r->slug }}">{{ $r->title }}</a></h2>
                        <p>{{ $r->excerpt }}</p>
                        <p><i class="fas fa-eye"></i>  {{ $r->view_counter }} Vistas</p>
                    <p><i class="fas fa-user"></i>  {{ $r->users->name }} <i class="fas fa-clock"></i> <time-ago>{{ $r->postponed_to }}</time-ago></p>
                    </div>
                </div>
            @endforeach
        </div>
        <a class="carousel-control-prev" href="#carouselExampleCaptions" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next" href="#carouselExampleCaptions" role="button" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
        </a>
    </div>
    <div class="go-to-posts animated slower infinite floatingRocket">
        <a href="#recentPost">
            <i class="fas fa-angle-double-down"></i>
        </a>
    </div>
</div>
{{-- Recents Articles in Grid Layout --}}
<div class="recent-box">
    <div id="recentPost" class="container-lg">
        <h3 class="section-title"><i class="fas fa-rss orange-text"></i> Lo más reciente</h3>
        <div class="recentPost">
            @foreach ($news as $n)
                <div class="box">
                    <div class="box__item">
                        <a href="/posts/{{ $n->slug }}">
                            <figure class="item__image">
                                <img
                                    class="animate-image"
                                    srcSet="{{ str_replace('1920', '480', $n->image) }} 480w,
                                    {{ str_replace('1920', '640', $n->image) }} 640w,
                                    {{ str_replace('1920', '800', $n->image) }} 800w,
                                    {{ str_replace('1920', '1200', $n->image) }} 1200w,
                                    {{ str_replace('1920', '1600', $n->image) }} 1600w,
                                    {{ $n->image }} 1920w"
                                    src="{{ $n->image !== null ? str_replace('1920', '800', $n->image) : '' }}"
                                    alt="{{ $n->title }}"
                                />
                            </figure>
                            <div class="item__overlayer"></div>
                            <div class="item__info bottom-attach">
                                <div class="info__news-category">{{ $n->categories->name }}</div>
                                <h2 class="info__news-title">
                                    {{ $n->title }}
                                </h2>
                                <h4 class="info__news-sub-title">{{ $n->excerpt }}</h4>
                                <p>
                                    <i class="fas fa-user"></i> <span class="info__person">{{ $n->users->name }}</span>
                                    <i class="fas fa-clock"></i> <time-ago>{{ $n->postponed_to }}</time-ago>
                                </p>
                            </div>
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
{{-- Anime Today Component --}}
<div id="broadcasting">
    <h3 className="section-title">
        <i className="fas fa-chromecast"></i> En emisión hoy
    </h3>
    <anime-today></anime-today>
</div>

{{-- All Articles in Grid Layout with Infinite Scroll --}}
<div class="posts-box">
	<div class="container-lg">
		<div class="grid">
			@forelse($posts as $post)
			<div class="grid-item">
				<!-- div class="row before-box" -->
					<div class="post">
						<div class="post-header">
							<div class="post-top-image">
								@if($post->categories->name === 'Videos')
                                    <div id="player" class="plyrs" data-plyr-provider="youtube" data-plyr-embed-id="{{str_replace('https://www.youtube.com/embed/','', $post->videoLinks['url'])}}"></div>
                                @else
                                    <a href="/posts/{{ $post->slug }}">
                                        @if(!empty($post->image))
                                            <img class="article-image" src="{{ str_replace('1920','480', $post->image) }}" alt="{{ $post->title }} - Coanime.net" />
                                        @else
                                            <img src="{{$helper->img_post($post->content)}}" alt="{{ $post->title }} - Coanime.net">
                                        @endif
                                    </a>
                                @endif
							</div>
							<a href="/categorias/{{ $post->categories->slug }}"><span class="post-category {{ $post->categories->slug }}">{{ $post->categories->name }}</span></a>
							<h2 class="post-title"><a href="/posts/{{ $post->slug }}">{{ $post->title }}</a></h2>
                            <div class="post-header-details">
                                <span class="post-author"><a href="{{ route('profile',$post->users->slug) }}">{{ $post->users->name }}</a></span>
                                @if ($post->postponed_to == $post->created_at || is_null($post->postponed_to))
                                @if (is_null($post->created_at))
                                    <time-ago>{{$post->post_crated_at}}</time-ago>
                                @else
                                    <time-ago>{{$post->created_at}}</time-ago>
                                @endif
                                @else
                                    <time-ago>{{$post->postponed_to}}</time-ago>
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
