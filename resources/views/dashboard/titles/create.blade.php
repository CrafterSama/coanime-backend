@inject('helper', 'App\Helper')

@extends('layouts.dashboard')

@if(Request::segment(4) == '')
	@section('title', 'Crear Titulo')
@else
	@section('title', 'Editar Titulo')
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
	{!! Form::open(['route'=>'titles.store', 'method'=>'POST', 'class' => 'form', 'files'=> 'true', 'data-toggle'=>'validator', 'role'=>'form']) !!}
	@else
	{!! Form::model($title, ['route' => ['titles.update', $title->id], 'class' => 'form', 'files'=> 'true', 'data-toggle'=>'validator']) !!}
	{{ method_field('PUT') }}
	@endif
		<div class="col-sm-12 col-md-9">
			<div class='form-group'>
			  {!! Form::label('name', 'Nombre') !!}
			  @if(Request::segment(4) == '')
			  {!! Form::text('name', null, ['class'=>'form-control', 'placeholder'=>'Nombre del Titulo (Ex.: XXXHolic)'], 'required') !!}
			  @else
			  {!! Form::text('name', $title->name, ['class'=>'form-control', 'placeholder'=>'Nombre del Titulo (Ex.: XXXHolic)'], 'required') !!}
			  @endif
			</div>
			<div class='form-group'>
			  {!! Form::label('other_titles', 'Otros Nombres/Titulos') !!} - <span class="pre">Coloquelos Separados por coma (,)</span>
			  @if(Request::segment(4) == '')
			  {!! Form::text('other_titles', null, ['id'=>'other_titles','class'=>'form-control', 'placeholder'=>'Nombre del Titulo (Ex.: XXX ホリック (Japonés))'], 'required') !!}
			  @else
			  {!! Form::text('other_titles', $title->other_titles, ['id'=>'other_titles','class'=>'form-control', 'placeholder'=>'Nombre del Titulo (Ex.: XXX ホリック (Japonés))'], 'required') !!}
			  @endif
			</div>
			<div class='form-group'>
				{!! Form::label('genere_id', 'Generos') !!}
				<br>
				@if(Request::segment(4) == '')
				{!! Form::select('genere_id[]', $generes, null, ['class'=>'select-genres', 'multiple' => 'multiple'], 'required') !!}
				@else
				{!! Form::select('genere_id[]', $generes, $selected, ['class'=>'select-genres', 'multiple' => 'multiple'], 'required') !!}
				@endif
			</div>
			<div class="form-group hidden-md hidden-lg">
				{!! Form::label('type_id', 'Típo') !!}
				@if(Request::segment(4) == '')
				{!! Form::select('type_id', $types, null, ['class'=>'select', 'data-style'=>'btn-select', 'data-width' => '100%']) !!}
				@else
				{!! Form::select('type_id', $types, $title->type_id, ['class'=>'select', 'data-style'=>'btn-select', 'data-width' => '100%']) !!}
				@endif
			</div>
			<div class='form-group'>
				{!! Form::label('sinopsis', 'Sinopsis') !!}
				@if(Request::segment(4) == '')
				{!! Form::textarea('sinopsis', null, ['id'=>'froala-editor','class'=>'form-control', 'placeholder'=>'Contenido del Post'], 'required') !!}
				@else
				{!! Form::textarea('sinopsis', $title->sinopsis, ['id'=>'froala-editor','class'=>'form-control', 'placeholder'=>'Contenido del Post'], 'required') !!}
				@endif
			</div>
		</div>
		<div class="post-sidebar col-sm-12 col-md-3">
			<div class="form-group hidden-sm hidden-xs">
				{!! Form::label('type_id', 'Tipo de Contenido') !!}
				@if(Request::segment(4) == '')
				{!! Form::select('type_id', $types, null, ['class'=>'select', 'data-style'=>'btn-select', 'data-width' => '100%']) !!}
				@else
				{!! Form::select('type_id', $types, $title->type_id, ['class'=>'select', 'data-style'=>'btn-select', 'data-width' => '100%']) !!}
				@endif
			</div>
			<div class="form-group">
				{!! Form::label('rating_id', 'Tipo de Audiencia') !!}
				@if(Request::segment(4) == '')
				{!! Form::select('rating_id', $ratings, null, ['class'=>'select', 'data-style'=>'btn-select', 'data-width' => '100%']) !!}
				@else
				{!! Form::select('rating_id', $ratings, $title->rating_id, ['class'=>'select', 'data-style'=>'btn-select', 'data-width' => '100%']) !!}
				@endif
			</div>
			<div class="form-group">
				{!! Form::label('status', 'Estatus') !!}
				@if(Request::segment(4) == '')
				{!! Form::select('status', ['En Emisión'=>'En Emisión', 'Finalizado'=>'Finalizado'], null, ['class'=>'select', 'data-style'=>'btn-select', 'data-width' => '100%']) !!}
				@else
				{!! Form::select('status', ['En Emisión'=>'En Emisión', 'Finalizado'=>'Finalizado'], $title->status, ['class'=>'select', 'data-style'=>'btn-select', 'data-width' => '100%']) !!}
				@endif
			</div>
			<div class="form-group">
				{!! Form::label('episodies', 'Episodios/Volumenes') !!}
				@if(Request::segment(4) == '')
				{!! Form::text('episodies', null, ['class'=>'form-control', 'placeholder'=>'Ej.:266'], 'required') !!}
				@else
				{!! Form::text('episodies', $title->episodies, ['class'=>'form-control', 'placeholder'=>'Ej.:266'], 'required') !!}
				@endif
			</div>
		    <div class="form-group">
		    	{!! Form::label('just_year', 'Solo Mostrar el Año') !!}<br />
		    	@if(Request::segment(4) == '')
		    	SI
				{!! Form::radio('just_year', 'true') !!}
				NO
				{!! Form::radio('just_year', 'false') !!}
				@else
					@if($title->just_year == true)
						SI
						{!! Form::radio('just_year', 'true', true) !!}
						NO
						{!! Form::radio('just_year', 'false') !!}
					@else
						SI
						{!! Form::radio('just_year', 'true') !!}
						NO
						{!! Form::radio('just_year', 'false', false) !!}
					@endif
				@endif
			</div>
		    <div class="form-group">
				{!! Form::label('broad_time', 'Priméra Emisión') !!}
                <div class='input-group date' id='broad_time'>
                	@if(Request::segment(4) == '')
                    {!! Form::text('broad_time', null, ['id'=>'input-broad-time','data-date-format'=>'YYYY-MM-DD HH:mm:ss', 'placeholder'=>'YYYY-MM-DD HH:mm:ss', 'class'=>'form-control']) !!}
                    @else
                    {!! Form::text('broad_time', $title->broad_time, ['id'=>'input-broad-time','data-date-format'=>'YYYY-MM-DD HH:mm:ss', 'placeholder'=>'YYYY-MM-DD HH:mm:ss', 'class'=>'form-control']) !!}
                    @endif
                    <span class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                    </span>
                </div>
            </div>
		    <div class="form-group">
				{!! Form::label('broad_finish', 'Última Emisión') !!}
                <div class='input-group date' id='broad_finish'>
                	@if(Request::segment(4) == '')
                    {!! Form::text('broad_finish', null, ['id'=>'input-broad-finish','data-date-format'=>'YYYY-MM-DD HH:mm:ss', 'placeholder'=>'YYYY-MM-DD HH:mm:ss', 'class'=>'form-control']) !!}
                    @else
                    {!! Form::text('broad_finish', $title->broad_finish, ['id'=>'input-broad-finish','data-date-format'=>'YYYY-MM-DD HH:mm:ss', 'placeholder'=>'YYYY-MM-DD HH:mm:ss', 'class'=>'form-control']) !!}
                    @endif
                    <span class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                    </span>
                </div>
            </div>
            <div class="form-group">
				{!! Form::label('trailer_url', 'Trailer del Titulo') !!}
				@if(Request::segment(4) == '')
				{!! Form::text('trailer_url', null, ['class'=>'form-control', 'placeholder'=>'Ej.:https://youtube.com/trailer-url']) !!}
				@else
				{!! Form::text('trailer_url', $title->trailer_url, ['class'=>'form-control', 'placeholder'=>'Ej.:https://youtube.com/trailer-url']) !!}
				@endif
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
			@if($title->images)
				<div class="form-group">
					{!! Form::label('image', 'Imagen del Titulo') !!}
					<img src="{{$title->images->thumbnail}}" alt="" class="img-thumbnail img-responsive" />
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
						<img name="iamge" id="image" src="#" alt="Estampado" class="img-thumbnail img-responsive" />
					</div>
				</div>
			@else
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
						<img id="image" src="#" alt="Estampado" class="img-thumbnail img-responsive" />
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
