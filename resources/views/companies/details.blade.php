@inject('helper', '\App\Helper')

@inject('carbon', '\Carbon\Carbon')

@extends('layouts.app')

@section('title', $company->name)
@section('description', str_limit(strip_tags($company->about), 140))
@section('twitter-image', 'https://coanime.net//images/no_image.jpg')

@section('content')
<div class="title-details col-md-12">
	<h3 class="title-name text-center cyan-background"><a href="" onclick="history.back()" class="btn btn-warning btn-sm pull-left"><i class="fa fa-chevron-left"></i> Volver</a> {{$company->name}}</h3>
	<!-- div class="title-top-image hidden-md hidden-lg" {{-- @if(empty($company->image->name)) style="background-image: url(/images/no_image.jpg);" @else style="background-image: url(/images/encyclopedia/magazine/{{$company->image->name}});" @endif --}}></div -->

	<div class="title-info col-md-12">
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
							<span class="text-strong">Nombre:</span> <span class="text-italic">{{ $company->name }}</span>
						</div>
						<div>
							<span class="text-strong">Fecha de Fundacion: </span>
							@if($company->foundation_date == '0000-00-00 00:00:00' || $company->foundation_date == NULL)
							<span class="text-italic">Desconocida</span>
							@else
							<span class="text-italic">{{ $company->foundation_date->format('d/m/Y') }}</span>
							@endif
						</div>
						<div>
							<span class="text-strong">Pais del HQ:</span> <span class="text-italic">{{ $company->country->name }}</span>
						</div>
						<div>
							<span class="text-strong">Website:</span> <span class="text-italic"><a href="{{ $company->website }}" rel="nofollow">{{ $company->website }}</a></span>
						</div>
					</div>
					<div class="sinopsis text-justify">
						<h4 class="sub-title-info">Acerca de {{ $company->name }}</h4>
						{!! $company->about !!}
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- div class="sidebar col-md-3 hidden-xs hidden-sm">
		{{-- @if(empty($company->image->name))
			<img class="img-responsive" src="/images/no_image.jpg" alt="">
		@else
			<img class="img-responsive" src="/images/encyclopedia/magazine/{{$company->image->name}}" alt="">
		@endif --}}
	</div -->
</div>
@endsection