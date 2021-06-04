@inject('helper', 'App\Helper')
@inject('carbon', 'Carbon\Carbon')

@extends('layouts.dashboard')

@if(Request::segment(4) == '')
	@section('title', 'Crear Usuario')
@else
	@section('title', 'Editar Usuario')
@endif

@section('content')

    @include('dashboard.partials.top-title')

    @include('dashboard.partials.leftbar')

    <div class="forms-content col-md-10">
	@if (count($errors) > 0)
	    <div style="margin-top:25px;" class="alert alert-danger">
	        <ul>
	            @foreach ($errors->all() as $error)
	                <li>{{ $error }}</li>
	            @endforeach
	        </ul>
	    </div>
	@endif
	@if(Request::segment(4) == '')
	{!! Form::open(['route'=>'users.store', 'method'=>'POST', 'class' => 'form', 'files'=> 'true', 'data-toggle'=>'validator', 'role'=>'form']) !!}
	@else
	{!! Form::model($user, ['route' => ['users.update', $user->id], 'class' => 'form', 'files'=> 'true', 'data-toggle'=>'validator']) !!}
	{{ method_field('PUT') }}
	@endif
		<div class="col-sm-12 col-md-6">
			<div class='form-group'>
			  {!! Form::label('name', 'Nombre') !!}
			  @if(Request::segment(4) == '')
			  {!! Form::text('name', null, ['class'=>'form-control', 'placeholder'=>'Nombre Completo'], 'required') !!}
			  @else
			  {!! Form::text('name', $user->name, ['class'=>'form-control', 'placeholder'=>'Nombre Completo'], 'required') !!}
			  @endif
			</div>
			<div class='form-group'>
			  {!! Form::label('nick', 'Nickname/Apodo') !!}
			  @if(Request::segment(4) == '')
			  {!! Form::text('nick', null, ['id'=>'nick','class'=>'form-control', 'placeholder'=>'Nickname/Apodo'], 'required') !!}
			  @else
			  {!! Form::text('nick', $user->nick, ['id'=>'nick','class'=>'form-control', 'placeholder'=>'Nickname/Apodo'], 'required') !!}
			  @endif
			</div>
			<div class="form-group">
				{!! Form::label('birthday', 'Fecha de Cumpleaños') !!}
                <div class='input-group date' id='birthday'>
                	@if(Request::segment(4) == '')
                    {!! Form::text('birthday', null, ['id'=>'input-broad-time','data-date-format'=>'YYYY-MM-DD HH:mm:ss', 'placeholder'=>'YYYY-MM-DD HH:mm:ss', 'class'=>'form-control']) !!}
                    @else
                    {!! Form::text('birthday', $user->birthday, ['id'=>'input-broad-time','data-date-format'=>'YYYY-MM-DD HH:mm:ss', 'placeholder'=>'YYYY-MM-DD HH:mm:ss', 'class'=>'form-control']) !!}
                    @endif
                    <span class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                    </span>
                </div>
            </div>
			@if(Request::segment(4) == '')
				<div class="form-group">
					{!! Form::label('image-client', 'Avatar de Usuario') !!}
		            <div class="input-group">
		                <input type="text" class="form-control" readonly>
		                <label class="input-group-btn">
		                    <span class="btn btn-warning">
		                        <i class="fa fa-folder-open"></i>&nbsp;Buscar...<input class="image-client" name="image-client" type="file" style="display:none;">
		                    </span>
		                </label>
	            	</div>
				</div>
				<div class="form-group">
			        <div style="display: none;" class="thumbnail">
						<img id="image" src="#" alt="Image" class="img-responsive" />
					</div>
				</div>
			@else
				<div class="form-group">
				@if($user->image)
					<div class="form-group">
						{!! Form::label('image', 'Avatar de Usuario') !!}
						<img src="{{ $user->image }}" alt="" class="img-thumbnail img-responsive" />
					</div>
					<div class="form-group">
						{!! Form::label('image-client', 'Nueva Imagen') !!}
			            <div class="input-group">
			                <input type="text" class="form-control" readonly>
			                <label class="input-group-btn">
			                    <span class="btn btn-warning">
			                        <i class="fa fa-folder-open"></i>&nbsp;Buscar...<input class="image-client" name="image-client" type="file" style="display:none;">
			                    </span>
			                </label>
		            	</div>
					</div>
					<div class="form-group">
				        <div style="display: none;" class="thumbnail">
							<img name="iamge" id="image" src="#" alt="Image" class="img-thumbnail img-responsive" />
						</div>
					</div>
				@else
					<div class="form-group">
						{!! Form::label('image-client', 'Avatar de Usuario') !!}
			            <div class="input-group">
			                <input type="text" class="form-control" readonly>
			                <label class="input-group-btn">
			                    <span class="btn btn-warning">
			                        <i class="fa fa-folder-open"></i>&nbsp;Buscar...<input class="image-client" name="image-client" type="file" style="display:none;">
			                    </span>
			                </label>
		            	</div>
					</div>
					<div class="form-group">
				        <div style="display: none;" class="thumbnail">
							<img id="image" src="#" alt="Image" class="img-thumbnail img-responsive" />
						</div>
					</div>
				@endif
	        	</div>
        	@endif
			<div class='form-group'>
				{!! Form::label('bio', 'Bio del Usuario') !!}
				@if(Request::segment(4) == '')
				{!! Form::textarea('bio', null, ['id'=>'froala-editor','class'=>'form-control', 'placeholder'=>'Bio del Usuario'], 'required') !!}
				@else
				{!! Form::textarea('bio', $user->bio, ['id'=>'froala-editor','class'=>'form-control', 'placeholder'=>'Bio del Usuario'], 'required') !!}
				@endif
			</div>
		</div>
		<div class="post-sidebar col-sm-12 col-md-6">
			<div class="form-group">
		    	{!! Form::label('genre', 'Genero') !!}<br />
		    	@if(Request::segment(4) == '')
		    	Femenino
				{!! Form::radio('genre', '0') !!}
				Masculino
				{!! Form::radio('genre', '1') !!}
				@else
					@if($user->genre == 0)
						Femenino
						{!! Form::radio('genre', '0', true) !!}
						Masculino
						{!! Form::radio('genre', '1') !!}
					@else
						Femenino
						{!! Form::radio('genre', '0') !!}
						Masculino
						{!! Form::radio('genre', '1', false) !!}
					@endif
				@endif
			</div>
			<div class="form-group">
				{!! Form::label('twitter', 'Twitter') !!}<br /><span class="pre">Coloque solo el nick del Servicio (Ejemplo: coanime)</span>
				@if(Request::segment(4) == '')
				{!! Form::text('twitter', null, ['class'=>'form-control', 'placeholder'=>'coanime'], 'required') !!}
				@else
				{!! Form::text('twitter', $user->twitter, ['class'=>'form-control', 'placeholder'=>'coanime'], 'required') !!}
				@endif
			</div>
			<div class="form-group">
				{!! Form::label('facebook', 'Facebook') !!}<br /><span class="pre">Coloque solo el nick del Servicio (Ejemplo: coanime)</span>
				@if(Request::segment(4) == '')
				{!! Form::text('facebook', null, ['class'=>'form-control', 'placeholder'=>'coanime'], 'required') !!}
				@else
				{!! Form::text('facebook', $user->facebook, ['class'=>'form-control', 'placeholder'=>'coanime'], 'required') !!}
				@endif
			</div>
			<div class="form-group">
				{!! Form::label('instagram', 'Instagram') !!}<br /><span class="pre">Coloque solo el nick del Servicio (Ejemplo: coanime)</span>
				@if(Request::segment(4) == '')
				{!! Form::text('instagram', null, ['class'=>'form-control', 'placeholder'=>'coanime'], 'required') !!}
				@else
				{!! Form::text('instagram', $user->instagram, ['class'=>'form-control', 'placeholder'=>'coanime'], 'required') !!}
				@endif
			</div>
			<div class="form-group">
				{!! Form::label('googleplus', 'Google+') !!}<br /><span class="pre">Coloque solo el nick del Servicio (Ejemplo: coanime)</span>
				@if(Request::segment(4) == '')
				{!! Form::text('googleplus', null, ['class'=>'form-control', 'placeholder'=>'coanime'], 'required') !!}
				@else
				{!! Form::text('googleplus', $user->googleplus, ['class'=>'form-control', 'placeholder'=>'coanime'], 'required') !!}
				@endif
			</div>
			<div class="form-group">
				{!! Form::label('behance', 'Behance') !!}<br /><span class="pre">Coloque solo el nick del Servicio (Ejemplo: coanime)</span>
				@if(Request::segment(4) == '')
				{!! Form::text('behance', null, ['class'=>'form-control', 'placeholder'=>'coanime'], 'required') !!}
				@else
				{!! Form::text('behance', $user->behance, ['class'=>'form-control', 'placeholder'=>'coanime'], 'required') !!}
				@endif
			</div>
			<div class="form-group">
				{!! Form::label('deviantart', 'Devian Art') !!}<br /><span class="pre">Coloque solo el nick del Servicio (Ejemplo: coanime)</span>
				@if(Request::segment(4) == '')
				{!! Form::text('deviantart', null, ['class'=>'form-control', 'placeholder'=>'coanime'], 'required') !!}
				@else
				{!! Form::text('deviantart', $user->deviantart, ['class'=>'form-control', 'placeholder'=>'coanime'], 'required') !!}
				@endif
			</div>
			<div class="form-group">
				{!! Form::label('tumblr', 'Tumblr') !!}<br /><span class="pre">Coloque solo el nick del Servicio (Ejemplo: coanime)</span>
				@if(Request::segment(4) == '')
				{!! Form::text('tumblr', null, ['class'=>'form-control', 'placeholder'=>'coanime'], 'required') !!}
				@else
				{!! Form::text('tumblr', $user->tumblr, ['class'=>'form-control', 'placeholder'=>'coanime'], 'required') !!}
				@endif
			</div>
			<div class="form-group">
				{!! Form::label('pinterest', 'Pinterest') !!}<br /><span class="pre">Coloque solo el nick del Servicio (Ejemplo: coanime)</span>
				@if(Request::segment(4) == '')
				{!! Form::text('pinterest', null, ['class'=>'form-control', 'placeholder'=>'coanime'], 'required') !!}
				@else
				{!! Form::text('pinterest', $user->pinterest, ['class'=>'form-control', 'placeholder'=>'coanime'], 'required') !!}
				@endif
			</div>
			<div class="form-group">
				{!! Form::label('website', 'Sitio Web') !!}<br /><span class="pre">Coloque solo la direccion sin el http:// o https:// (Ejemplo: coanime.net)</span>
				@if(Request::segment(4) == '')
				{!! Form::text('website', null, ['class'=>'form-control', 'placeholder'=>'coanime.net'], 'required') !!}
				@else
				{!! Form::text('website', $user->website, ['class'=>'form-control', 'placeholder'=>'coanime.net'], 'required') !!}
				@endif
			</div>
			<div class='form-group'>
				{!! Form::submit('Submit', ['class'=>'btn btn-primary btn-block']) !!}
				{!! Form::button('Cancel', ['onclick'=>'history.back()','class'=>'btn btn-default btn-block']) !!}
			</div>
		</div>
	{!! Form::close() !!}
</div>

@endsection
