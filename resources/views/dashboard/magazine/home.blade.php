@inject('helper', 'App\Helper')

@extends('layouts.app')

@section('title', 'Lista de Revistas')

@section('content')

@include('dashboard.partials.top-title')

@include('dashboard.partials.leftbar')

<div class="lists col-md-10">
	<div class="row">
		@include('partials.searchbox')
		<div class="search-box col-md-12">
			<a href="{{route('magazine.create')}}" class="btn btn-warning btn-sm"><i class="fa fa-plus"></i> Agregar Revista</a>
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
		@foreach($magazine as $mgz)
			<tr>
				<td>
					<div class="col-xs-6 col-sm-6 col-md-3">
						<p><a href="{{route('magazine')}}/{{$mgz->slug}}">{{$mgz->name}}</a></p>
					</div>
					<div class="col-md-3 text-center hidden-xs hidden-sm">
						<div>Autor: {{$mgz->users->name}}</div>
						<div>Categoria: {{$mgz->type->name}}</div>
					</div>
					<div class="col-md-3 text-center hidden-xs hidden-sm">
					@if (is_null($mgz->created_at))
						<span class="post_date">{{$helper->getDate($mgz->public_time)}}</span>
					@else
						<span class="post_date">{{$helper->getDate(strtotime($mgz->created_at,0))}}</span>
					@endif
					</div>
					<div class="col-xs-6 col-sm-6 col-md-3 text-center">
						@if(Auth::user()->id == $mgz->users->id || Auth::user()->isAdmin() || Auth::user()->isMod())
						<a href="{{ route('magazine.edit', $mgz->id) }}" class="btn btn-info btn-sm"><i class="fa fa-edit"></i> Editar</a>
						@endif
						@if(Auth::user()->isAdmin())
						<a id="delete-data-{{$mgz->id}}-submit" onclick="proceed({!!$mgz->id!!});" class="btn btn-danger btn-sm"><i class="fa fa-trash-o"></i> &nbsp;Borrar</a>
						{!! Form::open(['route' => ['magazine.destroy', $mgz->id], 'method' => 'DELETE', 'class' => 'form-horizontal', 'id' => 'delete-data-'.$mgz->id]) !!}
						{!! Form::close() !!}
						@endif
					</div>
				</td>
			</tr>
		@endforeach
		</tbody>
	</table>
	<div class="col-xs-12 col-sm-12 col-md-12 text-center">{{$magazine->appends(request()->all())->links()}}</div>
</div>
@endsection
