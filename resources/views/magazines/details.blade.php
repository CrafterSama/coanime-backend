@inject('helper', '\App\Helper')

@inject('carbon', '\Carbon\Carbon')

@extends('layouts.app')

@section('title', 'Coanime.net - Revistas - ' . $mgz->name)
@section('description', str_limit(strip_tags($mgz->about), 140))
@if(empty($mgz->images->name))
    @section('twitter-image', 'https://coanime.net//images/no_image.jpg')
@else
    @section('twitter-image', 'https://coanime.net/images/encyclopedia/magazine/' . $mgz->image->name)
@endif

@section('content')
<div class="title-details">
	<h3 class="title-name text-center cyan-background col-sx-12 col-sm-12 col-md-12 col-lg-12"><a href="" onclick="history.back()" class="btn btn-warning btn-sm pull-left"><i class="fa fa-chevron-left"></i> Volver</a> {{$mgz->name}}</h3>
	<div class="title-top-image hidden-md hidden-lg" @if(empty($mgz->image->name)) style="background-image: url(/images/no_image.jpg);" @else style="background-image: url(/images/encyclopedia/magazine/{{$mgz->image->name}});" @endif></div>

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
						<h4 class="sub-title-info">Información General</h4>
						<div>
							<span class="text-strong">Nombre de la Revista:</span> <span class="text-italic">{{$mgz->name}}</span>
						</div>
						<div>
							<span class="text-strong">Tipo:</span> <span class="text-italic">{{$mgz->type->name}}</span>
						</div>
						<div>
							<span class="text-strong">Frecuencia de Salida:</span> <span class="text-italic">{{$mgz->release->name}}</span>
						</div>
						<div>
							<span class="text-strong">Fecha de Fundacion: </span>
							@if($mgz->foundation_date == '0000-00-00' || $mgz->foundation_date == NULL)
							<span class="text-italic">Desconocida</span>
							@else
							<span class="text-italic">{{$mgz->foundation_date->format('d/m/Y')}}</span>
							@endif
						</div>
						<div>
							<span class="text-strong">Pais de Edicion:</span> <span class="text-italic">{{$mgz->country}}</span>
						</div>
						<div>
							<span class="text-strong">Website:</span> <span class="text-italic"><a href="{{$mgz->website}}" rel="nofollow">{{$mgz->website}}</a></span>
						</div>
					</div>
					<div class="sinopsis text-justify">
						<h4 class="sub-title-info">Acerca de {{$mgz->name}}</h4>
						{!! $helper->parseBBCode($mgz->about) !!}
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="sidebar col-md-3 hidden-xs hidden-sm">
		@if(empty($mgz->image->name))
			<img class="img-responsive" src="/images/no_image.jpg" alt="">
		@else
			<img class="img-responsive" src="/images/encyclopedia/magazine/{{$mgz->image->name}}" alt="">
		@endif
	</div>
</div>
@endsection
