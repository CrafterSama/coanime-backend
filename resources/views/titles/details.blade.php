@inject('helper', 'App\Helper')
@inject('carbon', 'Carbon\carbon')

@section('title', $title->type->name.' - '.$title->name )
@section('description', str_limit(strip_tags($title->sinopsis), 170))
@if(empty($title->images->name))
    @section('twitter-image', 'https://coanime.net//images/no_image.jpg')
@else
    @section('twitter-image', 'https://coanime.net/images/encyclopedia/titles/' . $title->images->name)
@endif

@extends('layouts.app')

@section('content')
<div class="title-details col-md-12">
    <h3 class="title-name text-center">
        <a href="/ecma/titulos" class="btn btn-warning btn-sm pull-left"><i class="fa fa-chevron-left"></i> Volver</a>
        <span id="title-name">{{$title->name}}</span>
        @if(Auth::guest() == false)
            @if(Auth::user()->isAdmin() || Auth::user()->isMod())
            <span class="pull-right"><a href="/dashboard/titles/{{$title->id}}/edit" class="btn btn-info btn-sm" data-container="body" data-toggle="tooltip" data-placement="top" title="Editar"><i class="fa fa-pencil"></i></a></span>
            @endif
        @endif
    </h3>
    <div class="title-top-image hidden-md hidden-lg" @if(empty($title->images->name)) style="background-image: url(/images/no_image.jpg);" @else style="background-image: url({{$title->images->name}});" @endif></div>

    <div class="title-info col-md-8">
        <div role="tabpanel">
            <!-- Nav tabs -->
            <ul class="nav nav-tabs" role="tablist">
                <li role="presentation" class="active">
                    <a href="#home" aria-controls="home" role="tab" data-toggle="tab">Información</a>
                </li>
            </ul>
            <!-- Tab panes -->
            <div class="tab-content">
                <div role="tabpanel" class="tab-pane active" id="home">
                    <div class="sinopsis text-justify">
                        <h4 class="sub-title-info">Sinopsis</h4>
                        <span id="title-sinopsis">{!! $title->sinopsis !!}</span>
                    </div>
                    <div class="other-info">
                        <h4 class="sub-title-info">Otros Titulos</h4>
                        <div id="title-alternatives">
                            {!! $helper->split_str($title->other_titles) !!}
                        </div>
                    </div>
                    <div class="other-info">
                        <h4 class="sub-title-info">Información General</h4>
                        <div>
                            <span class="text-strong">Tipo:</span> <span id="title-type" class="text-italic"><a href="{{ route('titles') }}/{{$title->type->slug}}">{{$title->type->name}}</a></span>
                        </div>
                        <div>
                            <span class="text-strong">Clasificación:</span> <span id="title-rating" class="text-italic">{{$title->rating->name}}</span> <span class="text-justify">({{$title->rating->description}})</span>
                        </div>
                        <div class="title-categories">
                            <span class="text-strong">Generos:</span>
                            <span id="title-genres">
                                @foreach($title->generes as $genere)
                                    <a href="{{ route('genres') }}/{{ $genere->slug }}">{{$genere->name}}</a>
                                @endforeach
                            </span>
                        </div>
                        <div>
                            <span class="text-strong">Episodios:</span>
                            @if($title->episodies == 0)
                                <span class="text-italic">Desconocido</span>
                            @else
                                <span class="text-italic">{{$title->episodies}}</span>
                            @endif
                        </div>
                        <div>
                            <span class="text-strong">Primer Tiraje o Broadcast:</span>
                            @if($title->broad_time == '0000-00-00' || $title->broad_time == NULL)
                                <span id="broad-start-unknow" class="text-italic">Desconocida</span>
                            @else
                                @if($title->just_year == 'true')
                                    @if($title->broad_time->format('d') == '01' && $title->broad_time->format('m') == '01')
                                        <span class="text-italic">{{ $title->first_date_year }}</span>
                                    @else
                                        <span class="text-italic">{{ $title->first_date }}</span>
                                    @endif
                                @else
                                    <span class="text-italic">{{ $title->first_date }}</span>
                                @endif
                            @endif
                        </div>
                        <div>
                            <span class="text-strong">Ultimo Tiraje o Broadcast:</span>
                            @if($title->broad_finish == '0000-00-00' || $title->broad_finish == NULL)
                                <span id="broad-ends-unknow" class="text-italic">Desconocida</span>
                            @else
                                @if($title->just_year == 'true')
                                    @if($title->broad_finish->format('d') == '01' && $title->broad_finish->format('m') == '01')
                                        <span class="text-italic">{{ $title->last_date_year }}</span>
                                    @else
                                        <span class="text-italic">{{ $title->last_date }}</span>
                                    @endif
                                @else
                                    <span class="text-italic">{{ $title->last_date }}</span>
                                @endif
                            @endif
                        </div>
                    </div>
                    <div class="other-info">
                        <h4 class="sub-title-info">Relacionados</h4>
                        <div id="title-relateds"></div>
                    </div>
                    @if( ($title->type->slug == 'dorama') || ($title->type->slug == 'k-drama') || ($title->type->slug == 'especial') || ($title->type->slug == 'live-action') || ($title->type->slug == 'ona') || ($title->type->slug == 'ova') || ($title->type->slug == 'pelicula') || ($title->type->slug == 'tv') )
                        <div class="other-info">
                            <h4 class="sub-title-info">Openings y Endings</h4>
                            <h5>Openings:</h5>
                            <ul id="title-openings"></ul>
                            <h5>Endings:</h5>
                            <ul id="title-endings"></ul>
                        </div>
                    @else
                    @endif
                </div>
            </div>
        </div>
    </div>
    <div class="sidebar col-md-4 hidden-xs hidden-sm">
        <div class="title-image">
            @if(empty($title->images->name))
                <img class="img-responsive" src="/images/no_image.jpg" alt="Enciclopedia - {{ $title->type->name . ' - ' . $title->name }} - Coanime.net" />
            @else
                <img class="img-responsive" src="{{$title->images->name}}" alt="Enciclopedia - {{ $title->type->name . ' - ' . $title->name }} - Coanime.net" />
            @endif
            @if($title->type->name != 'Juegos')
                @if($title->broad_finish == '0000-00-00' || $title->broad_finish == NULL || $title->status != 'Finalizado')
                    <span class="title-tag">En Emisión</span>
                @else
                    <span class="title-tag ended">Finalizado</span>
                @endif
            @endif
        </div>
        @if($title->type->slug != 'manga' || !$title->type->slug != 'manhua' || !$title->type->slug != 'manhwa' || !$title->type->slug != 'novela-ligera')
            <div class="other-info">
                <h4 class="sub-title-info">Trailer</h4>
                <div class="title-trailer">
                    @if(empty($title->trailer_url))
                        <div id="title-trailer" class="embed-responsive embed-responsive-16by9"></div>
                    @else
                        {{-- <div class="embed-responsive embed-responsive-16by9">
                            <iframe src="{{str_replace('https://www.youtube.com/watch?v=','https://www.youtube.com/embed/', $title->trailer_url)}}" frameborder="0" allowfullscreen></iframe>
                        </div> --}}
                        <div id="player" data-plyr-provider="youtube" data-plyr-embed-id="{{str_replace('https://www.youtube.com/watch?v=','', $title->trailer_url)}}"></div>
                    @endif
                </div>
            </div>
        @endif
    </div>
</div>
@endsection
