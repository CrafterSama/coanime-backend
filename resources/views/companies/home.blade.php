@inject('helper', 'App\Helper')

@extends('layouts.app')

@section('title', 'Coanime.net - Empresas del Medio' )
@section('description', 'Información sobre las compañías encargadas de los proyectos de anime, manga, live action, video juegos, entre otros. Pueden ser televisoras, estudios de animación o editorial.' )
@section('twitter-image', 'https://coanime.net/images/ecma-logo.png')


@section('content')
@include('partials.searchbox')
<div class="lists col-md-12">
	<table class="table table-rounded table-striped table-condensed cf">
		<thead>
			<tr>
				<th>
					<div class="col-xs-12 col-sm-12 col-md-10">Titulo de la Empresa / Estudio / Etc </div>
					<div class="col-md-2 text-center hidden-xs hidden-sm">Fecha</div>
				</th>
			</tr>
		</thead>
		<tbody>
		@forelse ($companies as $company)
			<tr>
				<td>
					<div class="col-xs-12 col-sm-12 col-md-9">
						<h4>
							<a class="title-name" href="/ecma/empresas/{{$company->slug}}">{{$company->name}}</a>
						</h4>
					</div>
					<div class="col-xs-12 col-sm-12 col-md-9">
						<p class="text-justify">{{str_limit(strip_tags($helper->parseBBCode($company->about)), 170)}} <a class="read-more" href="/ecma/empresas/{{$company->slug}}">Leer mas</a></p>
					</div>
					<div class="col-md-3 text-center hidden-xs hidden-sm">
					@if (is_null($company->created_at))
						<span class="post_date">{{$helper->getDate($company->public_time)}}</span>
					@else
						<span class="post_date">{{$helper->getDate(strtotime($company->created_at,0))}}</span>
					@endif
					</div>
				</td>
			</tr>
		@empty
			{{-- TODO: Mensaje temporal. Agregar una mensaje más apropiado --}}
			<tr>
				<td>
					<div class="col-xs-12">
						<div class="text-center">
							<em>No se encontraron coincidencias.</em>
						</div>
					</div>
				</td>
			</tr>
		@endforelse


		</tbody>
	</table>
	<div class="col-xs-12 col-sm-12 col-md-12 text-center">{{$companies->appends(request()->all())->links()}}</div>
</div>
@endsection
