@inject('helper', 'App\Helper')

@extends('layouts.dashboard')

@if(Request::segment(4) == '')
	@section('title', 'Crear Revista')
@else
	@section('title', 'Editar Revista '.$magazine->name)
@endif

@section('content')
@include('dashboard.partials.top-title')
@include('dashboard.partials.leftbar')
<div class="forms-content col-md-10">
	@if (count($errors) > 0)
	    <div class="alert alert-danger">
	        <ul>
	            @foreach ($errors->all() as $error)
	                <li>{{ $error }}</li>
	            @endforeach
	        </ul>
	    </div>
	@endif
	@if(Request::segment(4) == '')
	{!! Form::open(['route'=>'magazine.store', 'method'=>'POST', 'class' => 'form', 'files'=> 'true', 'data-toggle'=>'validator', 'role'=>'form']) !!}
	@else
	{!! Form::model($magazine, ['route' => ['magazine.update', $magazine->id], 'class' => 'form', 'files'=> 'true', 'data-toggle'=>'validator']) !!}
	{{ method_field('PUT') }}
	@endif
		<div class="col-sm-12 col-md-9">
			<div class='form-group'>
			  {!! Form::label('name', 'Nombre') !!}
			  @if(Request::segment(4) == '')
			  {!! Form::text('name', null, ['class'=>'form-control', 'placeholder'=>'Nombre del Titulo (Ex.: XXXHolic)'], 'required') !!}
			  @else
			  {!! Form::text('name', $magazine->name, ['class'=>'form-control', 'placeholder'=>'Nombre del Titulo (Ex.: XXXHolic)'], 'required') !!}
			  @endif
			</div>
			<div class="form-group hidden-md hidden-lg">
				{!! Form::label('type_id', 'Típo') !!}
				@if(Request::segment(4) == '')
				{!! Form::select('type_id', $types, null, ['class'=>'select', 'data-style'=>'btn-select', 'data-width' => '100%']) !!}
				@else
				{!! Form::select('type_id', $types, $magazine->type_id, ['class'=>'select', 'data-style'=>'btn-select', 'data-width' => '100%']) !!}
				@endif
			</div>
			<div class='form-group'>
				{!! Form::label('about', 'Acerca de') !!}
				@if(Request::segment(4) == '')
				{!! Form::textarea('about', null, ['id'=>'froala-editor','class'=>'form-control', 'placeholder'=>'Contenido del Post'], 'required') !!}
				@else
				{!! Form::textarea('about', $magazine->about, ['id'=>'froala-editor','class'=>'form-control', 'placeholder'=>'Contenido del Post'], 'required') !!}
				@endif
			</div>
		</div>
		<div class="post-sidebar col-sm-12 col-md-3">
			<div class="form-group hidden-sm hidden-xs">
				{!! Form::label('type_id', 'Tipo de Contenido') !!}
				@if(Request::segment(4) == '')
				{!! Form::select('type_id', $types, null, ['class'=>'select', 'data-style'=>'btn-select', 'data-width' => '100%']) !!}
				@else
				{!! Form::select('type_id', $types, $magazine->type_id, ['class'=>'select', 'data-style'=>'btn-select', 'data-width' => '100%']) !!}
				@endif
			</div>
			<div class="form-group">
				{!! Form::label('rating_id', 'Frecuencia de Salida') !!}
				@if(Request::segment(4) == '')
				{!! Form::select('release_id', $releases, null, ['class'=>'select', 'data-style'=>'btn-select', 'data-width' => '100%']) !!}
				@else
				{!! Form::select('release_id', $releases, $magazine->release_id, ['class'=>'select', 'data-style'=>'btn-select', 'data-width' => '100%']) !!}
				@endif
			</div>
			<div class="form-group">
				{!! Form::label('country_code', 'Pais') !!}
				@if(Request::segment(4) == '')
				{!! Form::select('country_code', ['' => 'Seleccione'], null, ['id'=>'countries','class'=>'select', 'data-style'=>'btn-select', 'data-width' => '100%'], 'required') !!}
				@else
				{!! Form::select('country_code', $countries, $magazine->country_code, ['id'=>'countries','class'=>'select', 'data-style'=>'btn-select', 'data-width' => '100%'], 'required') !!}
				@endif
			</div>
			<div class="form-group">
				{!! Form::label('website', 'Pagina Web') !!}
				@if(Request::segment(4) == '')
				{!! Form::text('website', null, ['class'=>'form-control', 'placeholder'=>'http://'], 'required') !!}
				@else
				{!! Form::text('website', $magazine->website, ['class'=>'form-control', 'placeholder'=>'Ej.:266'], 'required') !!}
				@endif
			</div>
		    <div class="form-group">
				{!! Form::label('foundation_date', 'Fecha de Fundación') !!}
                <div class='input-group date' id='foundation_date'>
                	@if(Request::segment(4) == '')
                    {!! Form::text('foundation_date', null, ['id'=>'input-foundation-date','data-date-format'=>'YYYY-MM-DD HH:mm:ss', 'placeholder'=>'YYYY-MM-DD HH:mm:ss', 'class' => 'form-control']) !!}
                    @else
                    {!! Form::text('foundation_date', $magazine->foundation_date, ['id'=>'input-foundation-date','data-date-format'=>'YYYY-MM-DD HH:mm:ss', 'class'=>'form-control']) !!}
                    @endif
                    <span class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                    </span>
                </div>
            </div>
			@if(Request::segment(4) == '')
			<div class="form-group">
				{!! Form::label('image-client', 'Imagen del Titulo') !!}
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
					<img id="image" src="#" alt="Estampado" class="img-responsive" />
				</div>
			</div>
			@else
			<div class="form-group">
			@if($magazine->image)
				{!! Form::label('image-client', 'Portada') !!}
				<img src="/../../images/encyclopedia/magazine/{{$magazine->image->name}}" alt="" width="300px" class="img-thumbnail" />
				<div class="form-group">
					{!! Form::label('image-client', 'Nueva Portada') !!}
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
						<img id="image" src="#" alt="Estampado" class="img-responsive" />
					</div>
				</div>
			@else
				<div class="form-group">
					{!! Form::label('image-client', 'Portada') !!}
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
						<img id="image" src="#" alt="Estampado" class="img-responsive" />
					</div>
				</div>
			@endif
        	</div>
        	@endif
        	<input type="hidden" name="user_id" />
        	<input type="hidden" name="slug" />
        	<input type="hidden" name="images" />
			<div class='form-group'>
				{!! Form::submit('Submit', ['class'=>'btn btn-primary btn-block']) !!}
				{!! Form::button('Cancel', ['onclick'=>'history.back()','class'=>'btn btn-default btn-block']) !!}
			</div>
		</div>
	{!! Form::close() !!}
</div>
@endsection
