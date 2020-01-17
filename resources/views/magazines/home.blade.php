@inject('helper', 'App\Helper')

@extends('layouts.app')

@section('title', 'Enciclopedia - Revistas')
@section('description', 'Información sobre las revistas que publican sobre anime, manga y cultura del medio oriente asiático.' )
@section('twitter-image', 'https://coanime.net/images/ecma-logo.png')

@section('content')

<ecma-magazines section="{{ Request::segment(2) }}"></ecma-magazines>

{{-- <div class="lists col-md-12">
	<table class="table table-rounded table-striped table-condensed cf">
		<thead>
			<tr>
				<th>
					<div class="col-xs-12 col-sm-12 col-md-10">Nombre de la Revista</div>
					<div class="col-md-2 text-center hidden-xs hidden-sm">Fecha</div>
				</th>
			</tr>
		</thead>
		<tbody>
		@foreach($magazine as $mgz)
			<tr>
				<td>
					<div class="col-md-2 hidden-xs hidden-sm">
					@if(empty($mgz->image->name))
						<img class="img-responsive img-thumbnail" src="/images/no_image.jpg" alt="">
					@else
						<img class="img-responsive img-thumbnail" src="/images/encyclopedia/magazine/{{$mgz->image->name}}" alt="">
					@endif
					</div>
					<div class="col-xs-12 col-sm-12 col-md-8">
						<h4>
							<a class="title-name" href="/ecma/revistas/{{$mgz->slug}}">{{$mgz->name}}</a> <span class="title-type">({{$mgz->type->name}})</span>
						</h4>
					</div>
					<div class="col-xs-12 col-sm-12 col-md-8">
						<p class="text-justify">{{str_limit(strip_tags($mgz->about), 170)}} <a class="read-more" href="/ecma/revistas/{{$mgz->slug}}">Leer mas</a></p>
					</div>
					<div class="col-md-2 text-center hidden-xs hidden-sm">
					@if (is_null($mgz->created_at))
						<span class="post_date">{{$helper->getDate($mgz->public_time)}}</span>
					@else
						<span class="post_date">{{$helper->getDate(strtotime($mgz->created_at,0))}}</span>
					@endif
					</div>
				</td>
			</tr>
		@endforeach
		</tbody>
	</table>
	<div class="col-xs-12 col-sm-12 col-md-12 text-center">{{$magazine->appends(request()->all())->links()}}</div>
</div> --}}
@endsection
