@inject('helper', 'App\Helper')
@inject('carbon', 'Carbon\Carbon')

@extends('layouts.dashboard')

@section('title', 'Lista de Posts')

@section('content')

@include('dashboard.partials.top-title')

@include('dashboard.partials.leftbar')

<div class="lists col-md-10">
	<div class="col-md-12">
		<table class="table table-rounded table-striped table-condensed cf">
			<thead>
				<tr>
					<th>
						<div class="col-md-12 text-center">
							Tipos de Titulos
						</div>
					</th>
				</tr>
			</thead>
			<tbody>
			@foreach($types as $type)
				<tr>
					<td>
						<div class="col-md-2">
							<p>{{$type->id}}</p>
						</div>
						<div class="col-md-4">
							<p>{{$type->name}}</p>
						</div>
						<div class="col-md-4">
							@if(Auth::user()->isAdmin() || Auth::user()->isMod())
							<a href="" class="btn btn-info btn-sm pull-right"><i class="fa fa-edit"></i></a>
							@endif
						</div>
					</td>
				</tr>
			@endforeach
			</tbody>
		</table>
	</div>
	<div class="col-md-12">
		<table class="table table-rounded table-striped table-condensed cf">
			<thead>
				<tr>
					<th>
						<div class="col-md-12 text-center">
							Categorias
						</div>
					</th>
				</tr>
			</thead>
			<tbody>
			@foreach($categories as $c)
				<tr>
					<td>
						<div class="col-md-2">
							<p>{{$c->id}}</p>
						</div>
						<div class="col-md-4">
							<p>{{$c->name}}</p>
						</div>
						<div class="col-md-4">
							@if(Auth::user()->isAdmin() || Auth::user()->isMod())
								<a href="" class="btn btn-info btn-sm pull-right"><i class="fa fa-edit"></i></a>
							@endif
						</div>
					</td>
				</tr>
			@endforeach
			</tbody>
		</table>
	</div>
	<div class="col-md-12">
		<table class="table table-rounded table-striped table-condensed cf">
			<thead>
				<tr>
					<th>
						<div class="col-md-12 text-center">
							Generos
						</div>
					</th>
				</tr>
			</thead>
			<tbody>
			@foreach($generes as $g)
				<tr>
					<td>
						<div class="col-md-2">
							<p>{{$g->id}}</p>
						</div>
						<div class="col-md-4">
							<p>{{$g->name}}</p>
						</div>
						<div class="col-md-4">
							@if(Auth::user()->isAdmin() || Auth::user()->isMod())
							<a href="" class="btn btn-info btn-sm pull-right"><i class="fa fa-edit"></i></a>
							@endif
						</div>
					</td>
				</tr>
			@endforeach
			</tbody>
		</table>
	</div>
	<div class="col-md-12">
		<table class="table table-rounded table-striped table-condensed cf">
			<thead>
				<tr>
					<th>
						<div class="col-md-12 text-center">
							Roles
						</div>
					</th>
				</tr>
			</thead>
			<tbody>
			@foreach($roles as $role)
				<tr>
					<td>
						<div class="col-md-2">
							<p>{{$role->id}}</p>
						</div>
						<div class="col-md-4">
							<p>{{$role->name}}</p>
						</div>
						<div class="col-md-4">
							@if(Auth::user()->isAdmin() || Auth::user()->isMod())
							<a href="" class="btn btn-info btn-sm pull-right"><i class="fa fa-edit"></i></a>
							@endif
						</div>
					</td>
				</tr>
			@endforeach
			</tbody>
		</table>
	</div>
	<div class="col-md-12">
		<table class="table table-rounded table-striped table-condensed cf">
			<thead>
				<tr>
					<th>
						<div class="col-md-12 text-center">
							Ratings PG-TV
						</div>
					</th>
				</tr>
			</thead>
			<tbody>
			@foreach($ratings as $r)
				<tr>
					<td>
						<div class="col-md-2">
							<p>{{$r->id}}</p>
						</div>
						<div class="col-md-4">
							<p>{{$r->name}}</p>
						</div>
						<div class="col-md-4">
							@if(Auth::user()->isAdmin() || Auth::user()->isMod())
							<a href="" class="btn btn-info btn-sm pull-right"><i class="fa fa-edit"></i></a>
							@endif
						</div>
					</td>
				</tr>
			@endforeach
			</tbody>
		</table>
	</div>
	<div class="col-md-12">
		<table class="table table-rounded table-striped table-condensed cf">
			<thead>
				<tr>
					<th>
						<div class="col-md-12 text-center">
							Configuraciones
						</div>
					</th>
				</tr>
			</thead>
		</table>
		<div class="col-md-4">
			<form action="" class="form-horizontal" role="form">
				@foreach($settings as $s)
					<div class="form-group">
						<label for="{{$s->setting_key}}">{{$s->setting_key}}</label>
						<input type="text" name="{{$s->setting_key}}" id="input" class="form-control" value="{{ $s->setting_value }}" required="required" pattern="" title="">
					</div>
				@endforeach
				<div class="form-group">
					<div class="col-md-12">
						<button type="submit" class="btn btn-primary">Guardar</button>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>

@endsection
