@inject('helper', 'App\Helper')

@extends('layouts.dashboard')

@section('title', 'Lista de Personas')

@section('content')

@include('dashboard.partials.top-title')

@include('dashboard.partials.leftbar')

<div class="lists col-md-10">
	<div class="row">
		@include('partials.searchbox')
		<div class="search-box col-md-12">
			<a href="{{route('people.create')}}" class="btn btn-warning btn-sm"><i class="fa fa-plus"></i> Agregar Persona</a>
		</div>
	</div>
	<table class="table table-rounded table-striped table-condensed cf">
		<thead>
			<tr>
				<th>
					<div class="col-xs-6 col-sm-6 col-md-3">Nombre </div>
					<div class="col-xs-3 col-sm-3 col-md-3 text-center hidden-xs hidden-sm">Detalles </div>
					<div class="col-xs-3 col-sm-3 col-md-3 text-center hidden-xs hidden-sm">Fecha </div>
					<div class="col-xs-6 col-sm-6 col-md-3 text-center">Acciones</div>
				</th>
			</tr>
		</thead>
		<tbody>
		@foreach($people as $person)
			<tr>
				<td>
					<div class="col-xs-6 col-sm-6 col-md-3">
						<p><a href="{{route('people')}}/{{$person->slug}}">{{$person->name}}</a></p>
					</div>
					<div class="col-md-3 text-center hidden-xs hidden-sm">
						<div>Autor: {{$person->users->name}}</div>
					</div>
					<div class="col-md-3 text-center hidden-xs hidden-sm">
						@if (is_null($person->created_at))
							<span class="post_date">{{$helper->getDate($person->public_time)}}</span>
						@else
							<span class="post_date">{{$helper->getDate(strtotime($person->created_at,0))}}</span>
						@endif
					</div>
					<div class="col-xs-6 col-sm-6 col-md-3 text-center">
						@if(Auth::user()->id == $person->users->id || Auth::user()->isAdmin() || Auth::user()->isMod())
							<a href="{{ route('people.edit', $person->id) }}" class="btn btn-info btn-sm"><i class="fa fa-edit"></i> Editar</a>
						@endif
						@if(Auth::user()->isAdmin())
							<a id="delete-data-{{$person->id}}-submit" onclick="proceed({!!$person->id!!});" class="btn btn-danger btn-sm"><i class="fa fa-trash-o"></i> &nbsp;Borrar</a>
							{!! Form::open(['route' => ['people.destroy', $person->id], 'method' => 'DELETE', 'class' => 'form-horizontal', 'id' => 'delete-data-'.$person->id]) !!}
							{!! Form::close() !!}
						@endif
					</div>
				</td>
			</tr>
		@endforeach
		</tbody>
	</table>
	<div class="col-xs-12 col-sm-12 col-md-12 text-center">{{$people->appends(request()->all())->links()}}</div>
</div>
@endsection
