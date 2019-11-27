@inject('helper', 'App\Helper')

@section('title', 'Coanime.net - Personas - ' . $people->name )
@section('description', str_limit(strip_tags($people->bio), 140))
@if(empty($people->image))
    @section('twitter-image', 'https://coanime.net//images/no_image.jpg')
@else
    @section('twitter-image', 'https://coanime.net/images/encyclopedia/people/' . $people->image)
@endif

@extends('layouts.app')

@section('content')
<div class="title-details col-md-12">
	<h3 class="title-name text-center purple-background col-md-12"><a href="" onclick="history.back()" class="btn btn-warning btn-sm pull-left"><i class="fa fa-chevron-left"></i> Volver</a> {{$people->name}} ({{$people->japanese_name}}) @if($people->falldown == 'si') <i class="fa fa-plus"></i>@endif</h3>
	<div class="title-top-image hidden-md hidden-lg" @if(empty($people->image)) style="background-image: url(/images/no_image.jpg);" @else style="background-image: url(/images/encyclopedia/people/thumbnails/thumb-{{$people->image}});" @endif></div>

	<div class="title-info col-md-9">
		<div role="tabpanel">
			<!-- Nav tabs -->
			<ul class="nav nav-tabs" role="tablist">
				<li role="presentation" class="active">
					<a href="#home" aria-controls="home" role="tab" data-toggle="tab">Informacion</a>
				</li>
			</ul>
			<!-- Tab panes -->
			<div class="tab-content">
				<div role="tabpanel" class="tab-pane active" id="home">
					<div class="other-info">
						<h4 class="sub-title-info">Datos Personales Conocidos</h4>
						<div>
							<span class="text-strong">Nombre Completo:</span> <span class="text-italic">{{$people->name}}</span>
						</div>
						<div>
							@if($people->birthday == NULL || $people->birthday == '0000-00-00')
								<span class="text-strong">Fecha de Nacimiento:</span> <span class="text-italic">Desconocida</span>
							@else
								<span class="text-strong">Fecha de Nacimiento:</span> <span class="text-italic">{{$people->birthday->format('d/m/Y')}}</span>
							@endif
						</div>
						@if($people->falldown == 'si')
							<div>
								@if($people->birthday == NULL || $people->birthday == '0000-00-00')
									<span class="text-strong">Fecha de Desceso:</span> <span class="text-italic">Desconocida</span>
								@else
									<span class="text-strong">Fecha de Desceso:</span> <span class="text-italic">{{$people->falldown_date->format('d/m/Y')}}</span>
								@endif
							</div>
						@endif
						<div>
							<span class="text-strong">Lugar de Nacimiento:</span>
							<span class="text-italic">
								@if(is_null($people->city))
									Ciudad y Distrito Desconocidos,
								@else
									{{$people->city->name}}, {{$people->city->district}},</span>
								@endif
								@if(is_null($people->country))
									Pais Desconocido
								@else
									{{$people->country->name}}
								@endif
							</span>
						</div>
						<div>
							<span class="text-strong">Areas / Habilidades / Hobbies:</span> <span class="text-italic">{{$people->areas_skills_hobbies}}</span>
						</div>
					</div>
					<div class="sinopsis text-justify">
						<h4 class="sub-title-info">Bio Conocida</h4>
						{!! $helper->parseBBCode($people->bio) !!}
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="sidebar col-md-3 hidden-xs hidden-sm">
		@if(empty($people->image))
			<img class="img-responsive" src="/images/no_image.jpg" alt="">
		@else
			<img class="img-responsive" src="/images/encyclopedia/people/{{$people->image}}" alt="">
		@endif
		<div class="sharethis-inline-share-buttons"></div>
	</div>
</div>
@endsection
