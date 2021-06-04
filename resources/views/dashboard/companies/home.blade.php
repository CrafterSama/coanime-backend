@inject('helper', 'App\Helper')

@extends('layouts.dashboard')

@section('title', 'Lista de Empresas')

@section('content')

@include('dashboard.partials.top-title')

@include('dashboard.partials.leftbar')

<div class="lists col-md-10">
	<div class="row">
		@include('partials.searchbox')
		<div class="search-box col-md-12">
			<a href="{{route('companies.create')}}" class="btn btn-warning btn-sm"><i class="fa fa-plus"></i> Agregar Empresa</a>
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
		@foreach($companies as $company)
			<tr>
				<td>
					<div class="col-xs-6 col-sm-6 col-md-3">
						<p><a href="{{route('companies')}}/{{$company->slug}}">{{$company->name}}</a></p>
					</div>
					<div class="col-md-3 text-center hidden-xs hidden-sm">
						<div>Autor: {{$company->users->name}}</div>
						@if($company->edited_by != NULL)
							<div>Editado por: {{$company->users->name}}</div>
						@endif
					</div>
					<div class="col-md-3 text-center hidden-xs hidden-sm">
					@if (is_null($company->created_at))
						<span class="post_date">{{$helper->getDate($company->public_time)}}</span>
					@else
						<span class="post_date">{{$helper->getDate(strtotime($company->created_at,0))}}</span>
					@endif
					</div>
					<div class="col-xs-6 col-sm-6 col-md-3 text-center">
						@if(Auth::user()->id == $company->users->id || Auth::user()->isAdmin() || Auth::user()->isMod())
						<a href="{{ route('companies.edit', $company->id) }}" class="btn btn-info btn-sm"><i class="fa fa-edit"></i> Editar</a>
						@endif
						@if(Auth::user()->isAdmin())
						<a id="delete-data-{{$company->id}}-submit" onclick="proceed({!!$company->id!!});" class="btn btn-danger btn-sm"><i class="fa fa-trash-o"></i> &nbsp;Borrar</a>
						{!! Form::open(['route' => ['companies.destroy', $company->id], 'method' => 'DELETE', 'class' => 'form-horizontal', 'id' => 'delete-data-'.$company->id]) !!}
						{!! Form::close() !!}
						@endif
					</div>
				</td>
			</tr>
		@endforeach
		</tbody>
	</table>
	<div class="col-xs-12 col-sm-12 col-md-12 text-center">{{$companies->appends(request()->all())->links()}}</div>
</div>
@endsection
