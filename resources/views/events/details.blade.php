@inject('helper', '\App\Helper')

@extends('layouts.app')

@section('title', $event->name)

@section('content')
<div class="title-details col-md-12">
	<h3 class="title-name text-center purple-background"><a href="" onclick="history.back()" class="btn btn-warning btn-sm pull-left"><i class="fa fa-chevron-left"></i> Volver</a> {{$event->name}} ({{$event->country->name}}, {{$event->country->continent}})</h3>
	<div class="title-top-image hidden-md hidden-lg" @if(empty($event->image)) style="background-image: url(/images/no_image.jpg);" @else style="background-image: url(/images/events/{{$event->image}});" @endif></div>

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
						<h4 class="sub-title-info">Datos Generales del Evento</h4>
						<div>
							<span class="text-strong">Fecha de Inicio:</span> <span class="text-italic">{{$event->date_start->format('d/m/Y')}}</span>
						</div>
						<div>
							<span class="text-strong">Fecha de Termino:</span> <span class="text-italic">{{$event->date_end->format('d/m/Y')}}</span>
						</div>
						<div>
							<span class="text-strong">Direccion Exacta:</span> <span class="text-italic">{{$event->address}}</span>
						</div>
						<div>
							<span class="text-strong">Lugar del Evento: </span> <span class="text-italic">{{$event->city->name}}, {{$event->city->district}}, {{$event->country->name}}</span>
						</div>
					</div>
					<div class="sinopsis text-justify">
						<h4 class="sub-title-info">Informacion Adicional</h4>
						{!! $event->description !!}
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="sidebar col-md-3 hidden-xs hidden-sm">
		@if(empty($event->image))
			<img class="img-responsive" src="/images/no_image.jpg" alt="">
		@else
			<img class="img-responsive" src="/images/events/{{$event->image}}" alt="">
		@endif
	</div>
</div>
@endsection
