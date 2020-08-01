@inject('helper', 'App\Helper')

@extends('layouts.dashboard')

@section('title', 'Lista de Posts')

@section('content')

@include('dashboard.partials.top-title')

@include('dashboard.partials.leftbar')

<div class="lists col-md-10">
	<div class="row">
		@include('partials.searchbox')
		<div class="search-box col-md-12">
			<a href="users/create" class="btn btn-warning btn-sm"><i class="fa fa-plus"></i> Agregar Usuario</a>
		</div>
	</div>
	<table class="table table-rounded table-striped table-condensed cf">
		<thead>
			<tr>
				<th>
					<div class="col-xs-6 col-sm-6 col-md-3">Usuario </div>
					<div class="col-xs-6 col-sm-6 col-md-2">Rol </div>
					<div class="col-xs-6 col-sm-6 col-md-2">Nick/Username </div>
					<div class="col-xs-6 col-sm-6 col-md-2 text-center hidden-xs hidden-sm">Registro </div>
					<div class="col-xs-6 col-sm-6 col-md-3 text-center">Acciones</div>
				</th>
			</tr>
		</thead>
		<tbody>
		@foreach($users as $user)
			<tr>
				<td>
					<div class="col-xs-6 col-sm-6 col-md-3">
						<p><a href="{{ route('profile',$user->slug) }}">{{ $user->name }}</a></p>
					</div>
					<div class="col-xs-6 col-sm-6 col-md-2">
						<p>{{$user->roles->name}}</p>
					</div>
					<div class="col-xs-6 col-sm-6 col-md-2">
						<p>{{$user->nick}}</p>
					</div>
					<div class="col-xs-6 col-sm-6 col-md-2 text-center hidden-xs hidden-sm">
					@if (is_null($user->created_at))
						<span class="post_date">{{$helper->getDate($user->public_time)}}</span>
					@else
						<span class="post_date">{{$helper->getDate(strtotime($user->created_at,0))}}</span>
					@endif
					</div>
					<div class="col-xs-6 col-sm-6 col-md-3 text-center">
						@if(Auth::user()->id == $user->id || Auth::user()->isAdmin() || Auth::user()->isMod())
						<a href="{{ route('users.edit', $user->id) }}" class="btn btn-info btn-sm"><i class="fa fa-edit"></i> Editar</a>
						@endif
						@if(Auth::user()->isAdmin())
						<a id="delete-data-{{$user->id}}-submit" onclick="proceed({!!$user->id!!});" class="btn btn-danger btn-sm"><i class="fa fa-trash-o"></i> &nbsp;Borrar</a>
						{!! Form::open(['route' => ['users.destroy', $user->id], 'method' => 'DELETE', 'class' => 'form-horizontal', 'id' => 'delete-data-'.$user->id]) !!}
						{!! Form::close() !!}
						@endif
					</div>
				</td>
			</tr>
		@endforeach
		</tbody>
	</table>
	<div class="col-xs-12 col-sm-12 col-md-12 text-center">{{$users->appends(request()->all())->links()}}</div>
</div>

@endsection
