@inject('helper', 'App\Helper')

@extends('layouts.app')

@section('title', 'Lista de Titulos')

@section('content')

@include('dashboard.partials.top-title')

@include('dashboard.partials.leftbar')

<div class="lists col-md-10">
	<div class="row">
		@include('partials.searchbox')
		<div class="search-box col-md-12">
			<a href="{{route('titles.create')}}" class="btn btn-warning btn-sm"><i class="fa fa-plus"></i> Agregar Titulo</a>
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
		@foreach($titles as $title)
			<tr>
				<td>
					<div class="col-xs-6 col-sm-6 col-md-3">
						<p><a href="{{ route('titles') }}/{{$title->type->slug}}/{{$title->slug}}">{{$title->name}}</a></p>
					</div>
					<div class="col-md-3 text-center hidden-xs hidden-sm">
						<div>Autor: {{$title->users->name}}</div>
						<div>Categoria: {{$title->type->name}}</div>
					</div>
					<div class="col-md-3 text-center hidden-xs hidden-sm">
					@if (is_null($title->created_at))
						<span class="post_date">{{$helper->getDate($title->public_time)}}</span>
					@else
						<span class="post_date">{{$helper->getDate(strtotime($title->created_at,0))}}</span>
					@endif
					</div>
					<div class="col-xs-6 col-sm-6 col-md-3 text-center">
						@if(Auth::user()->id == $title->users->id || Auth::user()->isAdmin() || Auth::user()->isMod())
						<a href="{{ route('titles.edit', $title->id) }}" class="btn btn-info btn-sm"><i class="fa fa-edit"></i> Editar</a>
						@endif
						@if(Auth::user()->isAdmin())
						<a id="delete-data-{{$title->id}}-submit" onclick="proceed({!!$title->id!!});" class="btn btn-danger btn-sm"><i class="fa fa-trash-o"></i> &nbsp;Borrar</a>
						{!! Form::open(['route' => ['titles.destroy', $title->id], 'method' => 'DELETE', 'class' => 'form-horizontal', 'id' => 'delete-data-'.$title->id]) !!}
						{!! Form::close() !!}
						@endif
					</div>
				</td>
			</tr>
		@endforeach
		</tbody>
	</table>
	<div class="col-xs-12 col-sm-12 col-md-12 text-center">{{$titles->appends(request()->all())->links()}}</div>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
<script>
function procceed(id) {
	swal({
		title: '¿Estas Seguro(a)?',
		text: '¡No podras reveritr esta acción!',
		type: 'warning',
		showCancelButton: true,
		confirmButtonColor: '#3085d6',
		cancelButtonColor: '#d33',
		confirmButtonText: 'Si, Borralo'
	}).then(function() {
		$('#delete-data-'+id).submit();
	}, function(dismiss) {
  		// dismiss can be 'cancel', 'overlay', 'close', 'timer'
		if (dismiss === 'cancel') {
    		swal(
      			'Cancelado',
      			'Tu Data esta a salvo',
      			'info'
    		);
  		};
	});
};
</script>
@endsection
