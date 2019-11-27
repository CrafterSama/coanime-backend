@inject('helper', '\App\Helper')
@inject('carbon', '\Carbon\Carbon')

@extends('layouts.app')

@section('title', 'Eventos')
@section('description', 'Información sobre los eventos que se realizarán en las regiones de habla hispanas de anime, manga, video juegos, doramas o de cultura del medio oriente asiático.')

@section('content')
<div class="home-encyclopedia col-md-12">
	<div class="encyclopedia-body">
		<h3 class="title-name text-center col-md-12 orange-backgound"><a href="" onclick="history.back()" class="btn btn-success btn-sm pull-left"><i class="fa fa-chevron-left"></i> Volver</a> Eventos de la Region del Habla Hispana</h3>
		@include('partials.searchbox')
		<div class="titles-section col-md-12">
			@foreach($events as $event)
			<div class="events col-md-4">
				<div class="items-boxes">
					@if(empty($event->image))
					<div class="titles-top-image" style="background-image: url(/images/no_image.jpg);">
					@else
					<div class="titles-top-image" style="background-image: url(/images/events/{{$event->image}});">
					@endif
						<div class="title-caption">
							<a href="/eventos/{{$event->slug}}">
								<h3 class="titles-name text-center">{{$event->name}}</h3>
								<div class="titles-body text-justify">
									{!!str_limit(strip_tags($event->description), 160)!!}
								</div>
							</a>
						</div>
					</div>
					<div class="titles-details text-right">
					@if(Auth::guest() == false)
						@if(Auth::user()->isAdmin() || Auth::user()->isMod() || Auth::user()->id == $event->users->id)
						<span class="pull-left">
							<a href="{{route('events.edit', $event->id)}}"><i class="fa fa-pencil"></i></a>
						</span>
						@endif
					@endif
						<span class="text-strong">Lugar: </span>
						<span class="text-italic">
							<i class="fa fa-map"></i> {{$event->city->name}}, {{$event->city->district}}, {{$event->country->name}}
						</span>
					</div>
				</div>
			</div>
			@endforeach
		</div>
		<div class="col-xs-12 col-sm-12 col-md-12 text-center">{{$events->appends(request()->all())->links()}}</div>
	</div>
</div>
@endsection
