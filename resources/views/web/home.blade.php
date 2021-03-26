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
            @foreach($relevants as $relevant)
            <div class="carousel-item @if ($loop->first) active @endif">
                    <figure class="carousel-image-box">
                        <img src="{{ $relevant->image }}" class="d-block" alt="{{ $relevant->title }}">
                        <particles></particles>
                    </figure>
                    <div class="overlayer"></div>

                    <div class="carousel-caption text-shadow d-xs-block">
                        <h3 class="section-title">Notas Destacadas</h3>
                        <h2><a href="/posts/{{ $relevant->slug }}">{{ $relevant->title }}</a></h2>
                        <p>{{ $relevant->excerpt }}</p>
                        <p><i class="fas fa-eye"></i>  {{ $relevant->view_counter }} Vistas</p>
                        <p><i class="fas fa-user"></i>  {{ $relevant->users->name }} <i class="fas fa-clock"></i> <time-ago>{{ $relevant->postponed_to }}</time-ago></p>
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
            @foreach ($news as $new)
                <div class="box">
                    <div class="box__item">
                        <figure class="item__image">
                            <a href="/posts/{{ $new->slug }}">
                                <img
                                    class="animate-image"
                                    srcSet="{{ str_replace('1920', '480', $new->image) }} 480w,
                                    {{ str_replace('1920', '640', $new->image) }} 640w,
                                    {{ str_replace('1920', '800', $new->image) }} 800w,
                                    {{ str_replace('1920', '1200', $new->image) }} 1200w,
                                    {{ str_replace('1920', '1600', $new->image) }} 1600w,
                                    {{ $new->image }} 1920w"
                                    src="{{ $new->image !== null ? str_replace('1920', '800', $new->image) : '' }}"
                                    alt="{{ $new->title }}"
                                />
                            </a>
                        </figure>
                        <div class="overlayer"></div>
                        <div class="item__info text-shadow bottom-attach">
                        <div class="info__news-category"><a href="/categorias/{{ $new->categories->slug }}">{{ $new->categories->name }}</a></div>
                            <h2 class="info__news-title">
                                <a href="/posts/{{ $new->slug }}">{{ $new->title }}</a>
                            </h2>
                            <h4 class="info__news-sub-title">{{ $new->excerpt }}</h4>
                            <p>
                            <i class="fas fa-user"></i> <span class="info__person">{{-- <a href="/users/profile/{{ $new->users->slug }}"> --}}{{ $new->users->name }}{{-- </a> --}}</span>
                                <i class="fas fa-clock"></i> <time-ago>{{ $new->postponed_to }}</time-ago>
                            </p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>

{{-- TODO: Videos Posts --}}



{{-- Anime Today Component --}}
<anime-today></anime-today>


{{-- TODO: Hispanic Events and Expos --}}


{{-- All Articles in Grid Layout with Infinite Scroll --}}
<all-posts></all-posts>

@endsection
