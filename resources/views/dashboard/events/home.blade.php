@inject('helper', 'App\Helper')

@extends('layouts.dashboard')

@section('title', 'Lista de Eventos')

@section('content')

@include('dashboard.partials.top-title')

@include('dashboard.partials.leftbar')

<div class="lists col-md-10">
	<div class="row">
		@include('partials.searchbox')
		<div class="search-box col-md-12">
			<a href="{{route('events.create')}}" class="btn btn-warning btn-sm"><i class="fa fa-plus"></i> Agregar Evento</a>
		</div>
	</div>
	<table class="table table-rounded table-striped table-condensed cf">
		<thead>
			<tr>
				<th>
					<div class="col-xs-6 col-sm-6 col-md-3">Titulo </div>
					<div class="col-xs-3 col-sm-3 col-md-3 text-center hidden-xs hidden-sm">Detalles </div>
					<div class="col-xs-3 col-sm-3 col-md-3 text-center hidden-xs hidden-sm">Fecha </div>
					<div class="col-xs-6 col-sm-6 col-md-3 text-center">Acciones</div>
				</th>
			</tr>
		</thead>
		<tbody>
		@foreach($events as $event)
			<tr>
				<td>
					<div class="col-xs-6 col-sm-6 col-md-3">
						<p><a href="{{route('events')}}/{{$event->slug}}">{{$event->name}}</a></p>
					</div>
					<div class="col-md-3 text-center hidden-xs hidden-sm">
						<div>Autor: {{$event->users->nick}}</div>
					</div>
					<div class="col-md-3 text-center hidden-xs hidden-sm">
					@if (is_null($event->created_at))
						<span class="post_date">{{$helper->getDate($event->public_time)}}</span>
					@else
						<span class="post_date">{{$helper->getDate(strtotime($event->created_at,0))}}</span>
					@endif
					</div>
					<div class="col-xs-6 col-sm-6 col-md-3 text-center">
						@if(Auth::user()->id == $event->users->id || Auth::user()->isAdmin() || Auth::user()->isMod())
						<a href="{{ route('events.edit', $event->id) }}" class="btn btn-info btn-sm"><i class="fa fa-edit"></i> Editar</a>
						@endif
						@if(Auth::user()->isAdmin())
						<a id="delete-data-{{$event->id}}-submit" onclick="proceed({!!$event->id!!});" class="btn btn-danger btn-sm"><i class="fa fa-trash-o"></i> &nbsp;Borrar</a>
						{!! Form::open(['route' => ['events.destroy', $event->id], 'method' => 'DELETE', 'class' => 'form-horizontal', 'id' => 'delete-data-'.$event->id]) !!}
						{!! Form::close() !!}
						@endif
					</div>
				</td>
			</tr>
		@endforeach
		</tbody>
	</table>
	<div class="col-xs-12 col-sm-12 col-md-12 text-center">{{$events->appends(request()->all())->links()}}</div>
</div>
@endsection
