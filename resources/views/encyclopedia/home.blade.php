@inject('helper', '\App\Helper')

@extends('layouts.app')

@section('title', 'Enciclopedia')

@section('content')
<div class="home-encyclopedia col-md-12">
	<div class="row encyclopedia-body">
		<h3 class="title-name text-center col-md-12 orange-background"><a href="" onclick="history.back()" class="btn btn-success btn-sm pull-left"><i class="fa fa-chevron-left"></i> Volver</a> Enciclopedia</h3>
		<div class="titles-section col-md-12">
			<h3 class="other-info-title col-md-12">Ultimos Titulos Agregados</h3>
			@foreach($titles as $title)
			<div class="col-md-4">
				<div class="items-boxes">
					@if(empty($title->images->name))
					<div class="titles-top-image" style="background-image: url(/images/no_image.jpg);">
						<div class="title-caption">
							<a href="{{ route('titles') }}/{{strtolower($title->type->name)}}/{{$title->slug}}">
								<h3 class="titles-name text-center">{{$title->name}}</h3>
								<div class="titles-body">
									{{str_limit(strip_tags($title->sinopsis), 250)}}
								</div>
							</a>
						</div>
					</div>
					@else
					<div class="titles-top-image" style="background-image: url({{$title->images->name}});">
						<div class="title-caption">
							<a href="{{ route('titles') }}/{{strtolower($title->type->name)}}/{{$title->slug}}">
								<h3 class="titles-name text-center">{{$title->name}}</h3>
								<div class="titles-body">
									{{str_limit(strip_tags($title->sinopsis), 250)}}
								</div>
							</a>
						</div>
					</div>
					@endif
					<div class="titles-details text-right">
						@if($title->type->name == 'TV')
						<span class="orange"><img class="fa-pg-tv" src="/images/pg-tv.svg" />{{$title->rating->name}}&nbsp;-&nbsp;<i class="fa fa-tv"></i> {{$title->type->name}}</span>
						@elseif($title->type->name == 'Manga')
						<span class="green"><img class="fa-pg-tv" src="/images/pg-tv.svg" />{{$title->rating->name}}&nbsp;-&nbsp;<i class="fa fa-book"></i> {{$title->type->name}}</span>
						@elseif($title->type->name == 'Pelicula')
						<span class="cyan"><img class="fa-pg-tv" src="/images/pg-tv.svg" />{{$title->rating->name}}&nbsp;-&nbsp;<i class="fa fa-film"></i> {{$title->type->name}}</span>
						@elseif($title->type->name == 'OVA')
						<span class="red"><img class="fa-pg-tv" src="/images/pg-tv.svg" />{{$title->rating->name}}&nbsp;-&nbsp;<i class="fa fa-video-camera"></i> {{$title->type->name}}</span>
						@elseif($title->type->name == 'Manhwa')
						<span class="gray"><img class="fa-pg-tv" src="/images/pg-tv.svg" />{{$title->rating->name}}&nbsp;-&nbsp;<i class="fa fa-book"></i> {{$title->type->name}}</span>
						@elseif($title->type->name == 'Movie')
						<span class="cyan"><img class="fa-pg-tv" src="/images/pg-tv.svg" />{{$title->rating->name}}&nbsp;-&nbsp;<i class="fa fa-film"></i> {{$title->type->name}}</span>
						@elseif($title->type->name == 'Live Action')
						<span class="purple"><img class="fa-pg-tv" src="/images/pg-tv.svg" />{{$title->rating->name}}&nbsp;-&nbsp;<i class="fa fa-users"></i> {{$title->type->name}}</span>
						@endif
					</div>
				</div>
			</div>
			@endforeach
			<div class="titles-section-footer col-md-12 text-right"><a href="{{ route('titles') }}" class="btn btn-default">Ver mas titulos <i class="fa fa-chevron-right"></i></a></div>
		</div>
		<div class="titles-section col-md-12">
			<h3 class="other-info-title col-md-12">Ultimas Personas Agregadas</h3>
			@foreach($people as $p)
			<div class="col-md-4">
				<div class="items-boxes">
					@if(empty($p->image))
						<div class="titles-top-image" style="background-image: url(/images/no_image.jpg);">
							<div class="title-caption">
								<a href="{{ route('people') }}/{{$p->slug}}">
									<h3 class="titles-name text-center">{{$p->name}}</h3>
									<div class="titles-body">
										{{str_limit(strip_tags($p->bio), 150)}}
									</div>
								</a>
							</div>
						</div>
					@else
						<div class="titles-top-image" style="background-image: url(/images/encyclopedia/people/{{$p->image}});">
							<div class="title-caption">
								<a href="{{ route('people') }}/{{$p->slug}}">
									<h3 class="titles-name text-center">{{$p->name}}</h3>
									<div class="titles-body">
										{{str_limit(strip_tags($p->bio), 150)}}
									</div>
								</a>
							</div>
						</div>
					@endif
					<div class="titles-details text-right">
						{{$p->areas_skills_hobbies}}
					</div>
				</div>
			</div>
			@endforeach
			<div class="titles-section-footer col-md-12 text-right"><a href="{{route('people')}}" class="btn btn-default">Ver mas personas <i class="fa fa-chevron-right"></i></a></div>
		</div>
		<div class="titles-section col-md-12">
			<h3 class="other-info-title col-md-12">Ultimos Revistas Agregadas</h3>
			@foreach($magazine as $mgz)
			<div class="col-md-4">
				<div class="items-boxes">
					@if(empty($mgz->image->name))
						<div class="titles-top-image" style="background-image: url(/images/no_image.jpg);">
							<div class="title-caption">
								<a href="{{ route('magazine') }}/{{$mgz->slug}}">
									<h3 class="titles-name text-center cyan-background">{{$mgz->name}}</h3>
									<div class="titles-body text-justify">
										{{str_limit(strip_tags($mgz->about), 200)}}
									</div>
								</a>
							</div>
						</div>
					@else
						<div class="titles-top-image" style="background-image: url(/images/encyclopedia/magazine/{{$mgz->image->name}});">
							<div class="title-caption">
								<a href="{{ route('magazine') }}/{{$mgz->slug}}">
									<h3 class="titles-name text-center cyan-background">{{$mgz->name}}</h3>
									<div class="titles-body text-justify">
										{{str_limit(strip_tags($mgz->about), 200)}}
									</div>
								</a>
							</div>
						</div>
					@endif
					<div class="titles-details text-right">
						@if($mgz->type->name == 'ShÅjo Manga')
						<span class="orange">Tiraje: {{$mgz->release->name}} &nbsp;-&nbsp;<i class="fa fa-book"></i> {{$mgz->type->name}}</span>
						@elseif($mgz->type->name == 'ShÅnen Manga')
						<span class="green">Tiraje: {{$mgz->release->name}} &nbsp;-&nbsp;<i class="fa fa-book"></i> {{$mgz->type->name}}</span>
						@elseif($mgz->type->name == 'Seinen Manga')
						<span class="cyan">Tiraje: {{$mgz->release->name}} &nbsp;-&nbsp;<i class="fa fa-book"></i> {{$mgz->type->name}}</span>
						@elseif($mgz->type->name == 'Josei Manga')
						<span class="red">Tiraje: {{$mgz->release->name}} &nbsp;-&nbsp;<i class="fa fa-book"></i> {{$mgz->type->name}}</span>
						@elseif($mgz->type->name == 'Kodomo Manga')
						<span class="orange">Tiraje: {{$mgz->release->name}} &nbsp;-&nbsp;<i class="fa fa-book"></i> {{$mgz->type->name}}</span>
						@endif
					</div>
				</div>
			</div>
			@endforeach
			<div class="titles-section-footer col-md-12 text-right"><a href="{{ route('magazine') }}" class="btn btn-default">Ver mas revistas <i class="fa fa-chevron-right"></i></a></div>
		</div>
		<div class="titles-section col-md-12">
			<h3 class="other-info-title col-md-12">Ultimas Empresas Agregadas</h3>
			@foreach($companies as $company)
			<div class="col-md-3">
				<div class="items-boxes">
					<h3 class="titles-name text-center"><a href="{{route('companies')}}/{{$company->slug}}">{{$company->name}}</a></h3>
					<div class="titles-body text-justify">
						{{str_limit(strip_tags($company->about), 40)}} <a href="{{route('companies')}}/{{$company->slug}}">Leer mas</a>
					</div>
					<div class="titles-details text-right">
						<span class="text-strong">Fecha de Fundacion: </span>
						@if($company->foundation_date == '0000-00-00')
							<span class="text-italic">Desconocida</span>
						@else
							<span class="text-italic">{{$company->foundation_date}}</span>
						@endif
					</div>
				</div>
			</div>
			@endforeach
			<div class="titles-section-footer col-md-12 text-right"><a href="{{route('companies')}}" class="btn btn-default">Ver mas empresas <i class="fa fa-chevron-right"></i></a></div>
		</div>

	</div>
</div>
@endsection
