@inject('helper', 'App\Helper')

@extends('layouts.app')

@section('title', 'Coanime.net - Titulos')
@section('description', 'SecciÃ³n general de la enciclopedia, puedes encontrar tÃ­tulos de Tv, Manga, Ovas, Novelas ligeras, Live Action, Video juegos, Doramas y mÃ¡s.')
@section('twitter-image', 'https://coanime.net/images/ecma-logo.png')


@section('content')
<div class="lists col-xs-12 col-sm-12 col-md-12">
@include('partials.searchbox')
<div class="clearfix"></div>
	<div class="hidden-xs hidden-sm col-md-2">
		<div class="titles-categories">
			<ul class="nav nav-pills nav-stacked">
				@if(Request::segment(2) == 'generos')
					<li @if(Request::segment(3) == '') class="active" @endif><a href="{{ route('genres') }}">Generos</a></li>
					@foreach($genres as $g)
					<li @if(Request::segment(3) == $g['slug']) class="active" @endif>
						<a href="{{ route('genres') }}/{{$g['slug']}}">{{$g['name']}}</a>
					</li>
					@endforeach
				@else
					<li @if(Request::segment(3) == '') class="active" @endif><a href="{{ route('titles') }}">Tipos</a></li>
					@foreach($types as $type)
					<li @if(Request::segment(3) == $type['slug']) class="active" @endif>
						<a href="{{ route('titles') }}/{{$type['slug']}}">{{$type['name']}}</a>
					</li>
					@endforeach
				@endif
			</ul>
		</div>
	</div>
	<div class="col-xs-12 col-sm-12 hidden-md hidden-lg">
		<div class="titles-categories">
			<div class="dropdown">
				<button class="btn btn-default btn-block dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
					Categorias
					<span class="caret"></span>
				</button>
				<ul class="dropdown-menu">
					@if(Request::segment(2) == 'generos')
						<li @if(Request::segment(3) == '') class="active" @endif><a href="{{ route('titles') }}">Generos</a></li>
						@foreach($genres as $g)
						<li @if(Request::segment(3) == $g['slug']) class="active" @endif>
							<a href="{{ route('genres') }}/{{$g['slug']}}">{{$g['name']}}</a>
						</li>
						@endforeach
					@else
						<li @if(Request::segment(3) == '') class="active" @endif><a href="{{ route('titles') }}">Tipos</a></li>
						@foreach($types as $type)
						<li @if(Request::segment(3) == $type['slug']) class="active" @endif>
							<a href="{{ route('titles') }}/{{$type['slug']}}">{{$type['name']}}</a>
						</li>
						@endforeach
					@endif
				</ul>
			</div>
		</div>
	</div>
	<div class="col-xs-12 col-sm-12 col-md-10 col-lg-10">
		<div class="row">
			<div class="titles-list">
				@foreach ($titles as $title)
				<div class="col-md-6">
					@if(empty($title->images->name))
					<div class="title-box">
					@else
					<div class="title-box" style="background-image: url({{$helper->getTitleImage($title->images->name)}});">
					@endif
						<div class="title-box-name">
							<a class="title-name" href="/ecma/titulos/{{ $title->type->slug }}/{{ $title->slug }}">
								<h4>{{$title->name}} <span class="title-type"></span></h4>
							</a>
							@if(Auth::guest() == false)
								@if(Auth::user()->isAdmin() || Auth::user()->isMod())
								<span class="pull-right"><a href="/dashboard/titles/{{$title->id}}/edit" class="btn btn-info btn-sm" data-container="body" data-toggle="tooltip" data-placement="top" title="Editar"><i class="fa fa-pencil"></i></a></span>
								@endif
							@endif
						</div>
						<div class="col-xs-6 col-sm-6 col-md-6 image-hidden-xs">
							<a class="title-name" href="/ecma/titulos/{{ $title->type->slug }}/{{ $title->slug }}">
							@if(empty($title->images->name))
								<img class="img-responsive" src="/images/no_image.jpg" alt=alt="Enciclopedia - {{ $title->type->name . ' - ' . $title->name }} - Coanime.net" />
							@else
								<img class="img-responsive" src="{{ $title->images->thumbnail }}" alt="Enciclopedia - {{ $title->type->name . ' - ' . $title->name }} - Coanime.net" />
                            @endif
							</a>
						</div>
						<div class="col-xs-6 col-sm-6 col-md-6 col-full-xs title-sinopsis">
							<p class="text-left">
							@if(empty($title->sinopsis))
								Agregar Sinopsis
								@if (Auth::guest())
								<a class="read-more" href="{{ url('/login') }}"><i class="fa fa-pencil"></i></a>
								@else
									@if(Auth::user()->isAdmin() || Auth::user()->isMod())
									<a class="read-more" href="/dashboard/titles?name={{ $title->name }}"><i class="fa fa-pencil"></i></a>
									@endif
								@endif
							@else
								{{str_limit(strip_tags($title->sinopsis), 170)}} <a class="read-more" href="/ecma/titulos/{{$title->type->slug}}/{{$title->slug}}">Leer mas</a>
							@endif
							</p>
							<div class="other-details">
								<div class="title-rate">
									<img class="fa-pg-tv" src="/images/pg-tv.svg" />{{$title->rating->name}}
								</div>
								@if($title->type->name == 'TV' || $title->type->name == 'Dorama')
								<div class="orange">
									<div class="title-inner-type">
										<a href="{{ route('titles') }}/{{$title->type->slug}}"><i class="fas fa-tv"></i> {{$title->type->name}}</a>
									</div>
								</div>
								@elseif($title->type->name == 'Manga' || $title->type->name == 'Novela Ligera')
								<div class="green">
									<div class="title-inner-type">
										<a href="{{ route('titles') }}/{{$title->type->slug}}"><i class="fas fa-book"></i> {{$title->type->name}}</a>
									</div>
								</div>
								@elseif($title->type->name == 'Pelicula')
								<div class="cyan">
									<div class="title-inner-type">
										<a href="{{ route('titles') }}/{{$title->type->slug}}"><i class="fas fa-film"></i> {{$title->type->name}}</a>
									</div>
								</div>
								@elseif($title->type->name == 'OVA' || $title->type->name == 'ONA')
								<div class="red">
									<div class="title-inner-type">
										<a href="{{ route('titles') }}/{{$title->type->slug}}"><i class="fas fa-video-camera"></i> {{$title->type->name}}</a>
									</div>
								</div>
								@elseif($title->type->name == 'Manhwa' || $title->type->name == 'Manhua')
								<div class="gray">
									<div class="title-inner-type">
										<a href="{{ route('titles') }}/{{$title->type->slug}}"><i class="fas fa-book"></i> {{$title->type->name}}</a>
									</div>
								</div>
								@elseif($title->type->name == 'Movie')
								<div class="cyan">
									<div class="title-inner-type">
										<a href="{{ route('titles') }}/{{$title->type->slug}}"><i class="fas fa-film"></i> {{$title->type->name}}</a>
									</div>
								</div>
								@elseif($title->type->name == 'Live Action')
								<div class="purple">
									<div class="title-inner-type">
										<a href="{{ route('titles') }}/{{$title->type->slug}}"><i class="fas fa-users"></i> {{$title->type->name}}</a>
									</div>
								</div>
								@elseif($title->type->name == 'Juegos')
								<div class="gray">
									<div class="title-inner-type">
										<a href="{{ route('titles') }}/{{$title->type->slug}}"><i class="fas fa-gamepad"></i> {{$title->type->name}}</a>
									</div>
								</div>
								@endif
                                @if($title->type->name != 'Juegos')
									@if($title->broad_finish == '0000-00-00' || $title->broad_finish == NULL || $title->status != 'Finalizado')
										<span class="title-tag">En Emisión</span>
									@else
										<span class="title-tag ended">Finalizado</span>
									@endif
                                @endif
                            </div>
						</div>
						<div class="clearfix"></div>
						<div class="title-box-footer">
							<p class="title-categories">
								<span>Generos:</span>
								@foreach($title->generes as $g)
									<a href="{{ route('genres') }}/{{ $g->slug }}">{{ $g->name }}</a>
								@endforeach
							</p>
						</div>
					</div>
				</div>
				@endforeach
			</div>
		</div>
	</div>
	<div class="col-xs-12 col-sm-12 col-md-12 text-center">
		{{$titles->appends(request()->all())->links()}}
	</div>
</div>
@endsection
