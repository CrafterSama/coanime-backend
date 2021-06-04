@inject('helper', 'App\Helper')

@extends('layouts.app')

@if(Request::segment(4) == '')
	@section('title', 'Crear Post')
@else
	@section('title', 'Editar Post')
@endif

@section('content')
@include('dashboard.partials.top-title')
@include('dashboard.partials.leftbar')
<div class="forms-content col-md-10">
	<div class="col-md-12 note">
		<p class="alert alert-info col-md-12"><u>Lea con Detenimiento:</u> existen dos formas para agregar imagenes al post la primera es darle al icono <i class="fa fa-image"></i> luego le da click al icono de la carpeta con la lupa y alli puede subir y escoger una imagen, y la segunda Vaya a nuestra Biblioteca de Imagenes <a href="http://images.coanime.net" class="btn btn-warning btn-xs" target="_blank">Coanime Image Host <i class="fa fa-link"></i></a>. Ya luego que suba la imagen el sistema le dara una URL la cual debe copiar, volver a esta pantalla y darle al boton <i class="fa fa-image"></i> para incluir la imagen donde lo prefiera.</p>
	</div>
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
		{!! Form::open(['route'=>'posts.store', 'method'=>'POST', 'id'=>'form', 'file' => 'true', 'data-toggle' => 'validator', 'role' => 'form', 'enctype' => 'multipart/form-data']) !!}
	@else
		{!! Form::model($post, ['route' => ['posts.update', $post->id], 'data-id'=> $post->id, 'id'=>'form', 'file' => 'true', 'data-toggle' => 'validator', 'role' => 'form', 'enctype' => 'multipart/form-data']) !!}
		{{ method_field('PUT') }}
	@endif
		<div class="col-sm-12 col-md-9">
			<div class='form-group'>
			  {!! Form::label('title', 'Titulo') !!}
			  @if(Request::segment(4) == '')
			  	{!! Form::text('title', null, ['class'=>'form-control input-lg', 'placeholder'=>'Titulo del Post'], 'required') !!}
			  @else
			  	{!! Form::text('title', $post->title, ['class'=>'form-control input-lg', 'placeholder'=>'Titulo del Post'], 'required') !!}
			  @endif
			  <div class="error-message"></div>
			</div>
			<div class="form-group hidden-md hidden-lg">
				{!! Form::label('category_id', 'Categorias') !!}
				@if(Request::segment(4) == '')
					{!! Form::select('category_id', $categories, null, ['class'=>'form-control input-lg'], 'required') !!}
				@else
					{!! Form::select('category_id', $categories, $post->category_id, ['class'=>'form-control input-lg'], 'required') !!}
				@endif
			</div>
			<div class='form-group'>
				{!! Form::label('content', 'Contenido') !!}
				@if(Request::segment(4) == '')
					{!! Form::textarea('content', null, ['id'=>'froala-editor','class'=>'form-control', 'placeholder'=>'Contenido del Post'], 'required') !!}
				@else
					{!! Form::textarea('content', $post->content, ['id'=>'froala-editor','class'=>'form-control', 'placeholder'=>'Contenido del Post'], 'required') !!}
				@endif
			</div>
		</div>
		<div class="post-sidebar col-sm-12 col-md-3">
			<div class="form-group hidden-sm hidden-xs">
				{!! Form::label('category_id', 'Categorias') !!}
				@if(Request::segment(4) == '')
					{!! Form::select('category_id', $categories, null, ['class'=>'form-control input-lg'], 'required') !!}
				@else
					{!! Form::select('category_id', $categories, $post->category_id, ['class'=>'form-control input-lg'], 'required') !!}
				@endif
			</div>
			<div class='form-group hidden-sm hidden-xs'>
				  {!! Form::label('postponed_to', 'Programado') !!}
				  @if(Request::segment(4) == '')
				  	{!! Form::text('postponed_to', null, ['id'=>'posponed-date','class'=>'form-control', 'data-date-format'=>'YYYY-MM-DD HH:mm:ss', 'placeholder'=>'YYYY-MM-DD HH:mm:ss'], 'required') !!}
				  @else
				  	{!! Form::text('postponed_to', $post->postponed_to, ['id'=>'posponed-date','class'=>'form-control','data-date-format'=>'YYYY-MM-DD HH:mm:ss', 'placeholder'=>'YYYY-MM-DD HH:mm:ss']) !!}
				  @endif
			</div>
			<div class='form-group hidden-sm hidden-xs search-title'>
				  {!! Form::label('title_id', 'Titulo Asociado') !!}
				  @if(Request::segment(4) == '')
				  		<input type="text" class="form-control" id="search-title" name="search-title" autocomplete="false" />
				  		<input type="hidden" class="form-control" id="title-id" name="title_id" />
				  		<div id="titles-response"></div>
				  @else
						@if ($post->titles->count() > 0)
							@foreach ($post->titles as $title)
							<div class="title-related">
								<img class="related-image img-responsive col-xs-12 col-sm-12 col-md-2" @if($title->images == null) src="/images/no_image.jpg" @else src="/images/encyclopedia/titles/thumb-{{ $title->images->name }} @endif" alt="">
								<div class="related-details col-xs-12 col-sm-12 col-md-10">
									<div class="related-name">
										<a href="{{ route('titles') }}/{{ str_slug($title->type->name) }}/{{ str_slug($title->name) }}"><h4>{{ $title->name }}</h4></a>
									</div>
									<div class="related-type"><small>{{ $title->type->name }}</small></div>
								</div>
								<div class="clearfix"></div>
							</div>
							@endforeach
						@endif
						<input type="text" class="form-control" id="search-title" name="search-title" autocomplete="false" />
						<input type="hidden" class="form-control" id="title-id" name="title_id" value="" />
						<div id="titles-response"></div>
				  @endif
			</div>
			@if(Auth::user()->id == 1)
				<div class="form-group hidden-sm hidden-xs">
					{!! Form::label('approved', 'Aprobado') !!}
					@if(Request::segment(4) == '')
					{!! Form::select('approved', ['yes' => 'yes','no' => 'no'], null, ['class'=>'selectpicker', 'data-style'=>'btn-select', 'data-width' => '100%']) !!}
					@else
					{!! Form::select('approved', ['yes' => 'yes','no' => 'no'], $post->approved, ['class'=>'selectpicker', 'data-style'=>'btn-select', 'data-width' => '100%']) !!}
					@endif
				</div>
			@endif
			@if(Request::segment(4) == '')
				<div class="form-group">
					{!! Form::label('image-client', 'Imagen Destacada') !!}
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
				@if($post->image)
					{!! Form::label('image-client', 'Imagen Destacada') !!}
					<img src="/../../images/posts/{{$post->image}}" alt="" width="300px" class="img-thumbnail" />
					<div class="form-group">
						{!! Form::label('image-client', 'Nueva Imagen Destacada') !!}
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
						{!! Form::label('image-client', 'Fotografia') !!}
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
			@endif
			<div class='form-group'>
					{!! Form::submit('Publicar', ['class'=>'btn btn-primary btn-block']) !!}
					{!! Form::button('Guardar Borrador', ['onclick'=>'saveData()','class'=>'btn btn-primary btn-block']) !!}
					{!! Form::button('Cancel', ['onclick'=>'history.back()','class'=>'btn btn-default btn-block']) !!}
			</div>
		</div>
	{!! Form::close() !!}
</div>
@endsection
