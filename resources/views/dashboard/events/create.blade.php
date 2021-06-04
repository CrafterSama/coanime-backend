@inject('helper', 'App\Helper')

@extends('layouts.dashboard')

@if(Request::segment(4) == '')
	@section('title', 'Crear Evento')
@else
	@section('title', 'Editando Evento '.$event->name)
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
	{!! Form::open(['route'=>'events.store', 'method'=>'POST', 'class' => 'form', 'files'=> 'true', 'data-toggle'=>'validator', 'role'=>'form']) !!}
	@else
	{!! Form::model($event, ['route' => ['events.update', $event->id], 'class' => 'form', 'files'=> 'true', 'data-toggle'=>'validator']) !!}
	{{ method_field('PUT') }}
	@endif
		<div class="col-sm-12 col-md-9">
			<div class='form-group'>
			  {!! Form::label('name', 'Nombre del Evento') !!}
			  @if(Request::segment(4) == '')
			  {!! Form::text('name', null, ['class'=>'form-control', 'placeholder'=>'Nombre del Evento (Ex.: ComicCon)'], 'required') !!}
			  @else
			  {!! Form::text('name', $event->name, ['class'=>'form-control', 'placeholder'=>'Nombre del Evento (Ex.: ComicCon)'], 'required') !!}
			  @endif
			</div>
			<div class='form-group'>
			  {!! Form::label('address', 'Dirección') !!}
			  @if(Request::segment(4) == '')
			  {!! Form::text('address', null, ['class'=>'form-control', 'placeholder'=>'Palacio de Bellas Artes'], 'required') !!}
			  @else
			  {!! Form::text('address', $event->address, ['class'=>'form-control', 'placeholder'=>'Palacio de Bellas Artes'], 'required') !!}
			  @endif
			</div>
			<div class='form-group'>
				{!! Form::label('description', 'Descripción') !!}
				@if(Request::segment(4) == '')
				{!! Form::textarea('description', null, ['id'=>'froala-editor','class'=>'form-control', 'placeholder'=>'Contenido del Post'], 'required') !!}
				@else
				{!! Form::textarea('description', $event->description, ['id'=>'froala-editor','class'=>'form-control', 'placeholder'=>'Contenido del Post'], 'required') !!}
				@endif
			</div>
		</div>
		<div class="post-sidebar col-sm-12 col-md-3">
			<div class='form-group'>
				{!! Form::label('country_code', 'Pais') !!}
				@if(Request::segment(4) == '')
				{!! Form::select('country_code', ['' => 'Seleccione'], null, [ 'id' => 'countries', 'class'=>'form-control']) !!}
				@else
				{!! Form::select('country_code', $countries, $event->country_code, [ 'id' => 'countries', 'class'=>'form-control']) !!}
				@endif

            </div>
			<div class='form-group'>
				{!! Form::label('city_id', 'Ciudad / Estado') !!}
				@if(Request::segment(4) == '')
				{!! Form::select('city_id', ['' => 'Seleccione'], null, [ 'id' => 'cities', 'class'=>'form-control']) !!}
				@else
				{!! Form::select('city_id', $cities, $event->city_id, [ 'id' => 'cities', 'class'=>'form-control']) !!}
				@endif
			</div>
			<div class="form-group" style="display: none;">
				{!! Form::label('website', 'Pagina Web') !!}
				@if(Request::segment(4) == '')
				{!! Form::text('website', null, ['class'=>'form-control', 'placeholder'=>'http://'], 'required') !!}
				@else
				{!! Form::text('website', $event->website, ['class'=>'form-control', 'placeholder'=>'Ej.:266'], 'required') !!}
				@endif
			</div>
		    <div class="form-group">
				{!! Form::label('date_start', 'Fecha de Inicio') !!}
                <div class='input-group date' id='date_start'>
                	@if(Request::segment(4) == '')
                    {!! Form::text('date_start', null, ['id'=>'input-broad-time','data-date-format'=>'YYYY-MM-DD', 'class'=>'form-control']) !!}
                    @else
                    {!! Form::text('date_start', $event->date_start, ['id'=>'input-broad-time','data-date-format'=>'YYYY-MM-DD', 'class'=>'form-control']) !!}
                    @endif
                    <span class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                    </span>
                </div>
            </div>
		    <div class="form-group">
				{!! Form::label('date_end', 'Fecha de Termino') !!}
                <div class='input-group date' id='date_end'>
                	@if(Request::segment(4) == '')
                    {!! Form::text('date_end', null, ['id'=>'input-broad-finish','data-date-format'=>'YYYY-MM-DD', 'class'=>'form-control']) !!}
                    @else
                    {!! Form::text('date_end', $event->date_end, ['id'=>'input-broad-finish','data-date-format'=>'YYYY-MM-DD', 'class'=>'form-control']) !!}
                    @endif
                    <span class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                    </span>
                </div>
            </div>
			@if(Request::segment(4) == '')
				<div class="form-group">
					{!! Form::label('image-client', 'Imagen/Panfleto del Evento') !!}
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
					@if($event->image)
						{!! Form::label('image-client', 'Imagen/Panfleto del Evento') !!}
						<img src="/../../images/events/{{$event->image}}" alt="" width="300px" class="img-thumbnail" />
						<div class="form-group">
							{!! Form::label('image-client', 'Nueva Imagen/Panfleto del Evento') !!}
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
