@inject('helper', 'App\Helper')

@extends('layouts.dashboard')

@if(Request::segment(4) == '')
	@section('title', 'Crear Persona')
@else
	@section('title', 'Editando el perfil de '.$person->name)
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
	{!! Form::open(['route'=>'people.store', 'method'=>'POST', 'class' => 'form', 'files'=> 'true', 'data-toggle'=>'validator', 'role'=>'form']) !!}
	@else
	{!! Form::model($person, ['route' => ['people.update', $person->id], 'class' => 'form', 'files'=> 'true', 'data-toggle'=>'validator']) !!}
	{{ method_field('PUT') }}
	@endif
		<div class="col-sm-12 col-md-9">
			<div class='form-group'>
			  {!! Form::label('name', 'Nombre') !!}
			  @if(Request::segment(4) == '')
			  {!! Form::text('name', null, ['class'=>'form-control', 'placeholder'=>'Osamu Tezuka'], 'required') !!}
			  @else
			  {!! Form::text('name', $person->name, ['class'=>'form-control', 'placeholder'=>'Osamu Tezuka'], 'required') !!}
			  @endif
			</div>
			<div class='form-group'>
			  {!! Form::label('japanese_name', 'Nombre Japonés') !!}
			  @if(Request::segment(4) == '')
			  {!! Form::text('japanese_name', null, ['class'=>'form-control', 'placeholder'=>'手塚 治虫'], 'required') !!}
			  @else
			  {!! Form::text('japanese_name', $person->japanese_name, ['class'=>'form-control', 'placeholder'=>'手塚 治虫'], 'required') !!}
			  @endif
			</div>
			<div class='form-group'>
			  {!! Form::label('areas_skills_hobbies', 'Habilidades/Areas/Hobbies') !!} - <span class="pre">Coloquelos Separados por coma (,)</span>
			  @if(Request::segment(4) == '')
			  {!! Form::text('areas_skills_hobbies', null, ['class'=>'form-control', 'placeholder'=>'Mangaka'], 'required') !!}
			  @else
			  {!! Form::text('areas_skills_hobbies', $person->areas_skills_hobbies, ['class'=>'form-control', 'placeholder'=>'Mangaka'], 'required') !!}
			  @endif
			</div>
			<div class='form-group'>
				{!! Form::label('bio', 'Mini Biografia') !!}
				@if(Request::segment(4) == '')
				{!! Form::textarea('bio', null, ['id'=>'froala-editor','class'=>'form-control', 'placeholder'=>'Contenido del Post'], 'required') !!}
				@else
				{!! Form::textarea('bio', $person->bio, ['id'=>'froala-editor','class'=>'form-control', 'placeholder'=>'Contenido del Post'], 'required') !!}
				@endif
			</div>
		</div>
		<div class="post-sidebar col-sm-12 col-md-3">
			<div class='form-group'>
				{!! Form::label('country_code', 'Pais') !!}
				@if(Request::segment(4) == '')
				{!! Form::select('country_code', ['' => 'Seleccione'], null, [ 'id' => 'countries', 'class'=>'form-control']) !!}
				@else
				{!! Form::select('country_code', $countries, $person->country_code, [ 'id' => 'countries', 'class'=>'form-control']) !!}
				@endif

            </div>
			<div class='form-group'>
				{!! Form::label('city_id', 'Ciudad/Lugar de Nacimiento') !!}
				@if(Request::segment(4) == '')
				{!! Form::select('city_id', ['' => 'Seleccione'], null, [ 'id' => 'cities', 'class'=>'form-control']) !!}
				@else
				{!! Form::select('city_id', $cities, $person->city_id, [ 'id' => 'cities', 'class'=>'form-control']) !!}
				@endif
			</div>
		    <div class="form-group">
				{!! Form::label('birthday', 'Fecha de Nacimiento') !!}
                <div class='input-group date' id='birthday'>
                	@if(Request::segment(4) == '')
                    {!! Form::text('birthday', null, ['id'=>'input-broad-time','class'=>'form-control','data-date-format'=>'YYYY-MM-DD HH:mm:ss', 'placeholder'=>'YYYY-MM-DD HH:mm:ss']) !!}
                    @else
                    {!! Form::text('birthday', $person->birthday, ['id'=>'input-broad-time','class'=>'form-control','data-date-format'=>'YYYY-MM-DD HH:mm:ss', 'placeholder'=>'YYYY-MM-DD HH:mm:ss']) !!}
                    @endif
                    <span class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                    </span>
                </div>
            </div>
			<div class="form-group">
				{!! Form::label('falldown', 'Fallecido') !!}
				<br>
				@if(Request::segment(4) == '')
				{!! Form::select('falldown', $falldown, null, ['id' => 'falldown','class'=>'select', 'data-style'=>'btn-select', 'data-width' => '100%'], 'required') !!}
				@else
				{!! Form::select('falldown', $falldown, $person->falldown, ['id' => 'falldown','class'=>'select', 'data-style'=>'btn-select', 'data-width' => '100%'], 'required') !!}
				@endif
			</div>
		    <div id="falldown_date" class="form-group" style="display: none;">
				{!! Form::label('falldown_date', 'Fecha de Fallecimiento') !!}
                <div class='input-group date' id='falldown_date'>
                	@if(Request::segment(4) == '')
                    {!! Form::text('falldown_date', null, ['id'=>'input-broad-finish','class'=>'form-control','data-date-format'=>'YYYY-MM-DD HH:mm:ss', 'placeholder'=>'YYYY-MM-DD HH:mm:ss']) !!}
                    @else
                    {!! Form::text('falldown_date', $person->falldown_date, ['id'=>'input-broad-finish','class'=>'form-control','data-date-format'=>'YYYY-MM-DD HH:mm:ss', 'placeholder'=>'YYYY-MM-DD HH:mm:ss']) !!}
                    @endif
                    <span class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                    </span>
                </div>
            </div>
			@if(Request::segment(4) == '')
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
			@else
			<div class="form-group">
			@if($person->image)
				{!! Form::label('image-client', 'Fotografia') !!}
				<img src="/../../images/encyclopedia/people/{{$person->image}}" alt="" width="300px" class="img-thumbnail" />
				<div class="form-group">
					{!! Form::label('image-client', 'Nueva Fotografia') !!}
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
