@inject('helper', 'App\Helper')

@extends('layouts.dashboard')

@if(Request::segment(4) == '')
	@section('title', 'Crear Empresa')
@else
	@section('title', 'Editando el perfil de '.$company->name)
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
	{!! Form::open(['route'=>'companies.store', 'method'=>'POST', 'class' => 'form', 'files'=> 'true', 'data-toggle'=>'validator', 'role'=>'form']) !!}
	@else
	{!! Form::model($company, ['route' => ['companies.update', $company->id], 'class' => 'form', 'files'=> 'true', 'data-toggle'=>'validator']) !!}
	{{ method_field('PUT') }}
	@endif
		<div class="col-sm-12 col-md-9">
			<div class='form-group'>
			  {!! Form::label('name', 'Nombre de la Empresa') !!}
			  @if(Request::segment(4) == '')
			  {!! Form::text('name', null, ['class'=>'form-control', 'placeholder'=>'Capcom'], 'required') !!}
			  @else
			  {!! Form::text('name', $company->name, ['class'=>'form-control', 'placeholder'=>'Capcom'], 'required') !!}
			  @endif
			</div>
			<div class='form-group'>
				{!! Form::label('about', 'Mini Biografia') !!}
				@if(Request::segment(4) == '')
				{!! Form::textarea('about', null, ['id'=>'froala-editor','class'=>'form-control', 'placeholder'=>'Contenido del Post'], 'required') !!}
				@else
				{!! Form::textarea('about', $company->about, ['id'=>'froala-editor','class'=>'form-control', 'placeholder'=>'Contenido del Post'], 'required') !!}
				@endif
			</div>
		</div>
		<div class="post-sidebar col-sm-12 col-md-3">
			<div class='form-group'>
				{!! Form::label('country_code', 'Pais') !!}
				@if(Request::segment(4) == '')
				{!! Form::select('country_code', ['' => 'Seleccione'], null, [ 'id' => 'countries', 'class'=>'form-control']) !!}
				@else
				{!! Form::select('country_code', $countries, $company->country_code, [ 'id' => 'countries', 'class'=>'form-control']) !!}
				@endif
            </div>
			<div class="form-group">
				{!! Form::label('website', 'Direccion Web') !!}
				@if(Request::segment(4) == '')
				{!! Form::text('website', null, ['class'=>'form-control', 'placeholder'=>'http://'], 'required') !!}
				@else
				{!! Form::text('website', $company->website, ['class'=>'form-control', 'placeholder'=>'http://'], 'required') !!}
				@endif
			</div>
		    <div class="form-group">
				{!! Form::label('foundation_date', 'Fecha de Fundación') !!}
                <div class='input-group date' id='foundation_date'>
                	@if(Request::segment(4) == '')
                    {!! Form::text('foundation_date', null, ['id'=>'input-foundation-date','data-date-format'=>'YYYY-MM-DD HH:mm:ss', 'class'=>'form-control']) !!}
                    @else
                    {!! Form::text('foundation_date', $company->foundation_date, ['id'=>'input-foundation-date','data-date-format'=>'YYYY-MM-DD HH:mm:ss', 'class'=>'form-control']) !!}
                    @endif
                    <span class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                    </span>
                </div>
            </div>
			@if(Request::segment(4) == '')
			<div class="form-group" style="display:none;">
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
			<div class="form-group" style="display:none;">
			@if($company->image)
				{!! Form::label('image-client', 'Fotografia') !!}
				<img src="/../../images/encyclopedia/people/{{$company->image}}" alt="" width="300px" class="img-thumbnail" />
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
        	<input type="hidden" name="edited_by" />

			<div class='form-group'>
				{!! Form::submit('Submit', ['class'=>'btn btn-primary btn-block']) !!}
				{!! Form::button('Cancel', ['onclick'=>'history.back()','class'=>'btn btn-default btn-block']) !!}
			</div>
		</div>
	{!! Form::close() !!}
</div>
@endsection
