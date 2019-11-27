@inject('helper', 'App\Helper')

@section('title', 'Personas')
@section('description', 'Sección donde encontrarás información sobre Autores, Directores, Seiyuus, Mangakas y personalidades del mundo del anime, manga o videojuegos.' )
@section('twitter-image', 'https://coanime.net/images/ecma-logo.png')

@extends('layouts.app')

@section('content')
@include('partials.searchbox')
<div class="lists col-md-12">
	<table class="table table-rounded table-striped table-condensed cf">
		<thead>
			<tr>
				<th>
					<div class="col-xs-12 col-sm-12 col-md-10">Autores / Directores / Seiyuus / Etc</div>
					<div class="col-md-2 text-center hidden-xs hidden-sm">Fecha</div>
				</th>
			</tr>
		</thead>
		<tbody>
		@foreach($people as $p)
			<tr>
				<td>
					<div class="col-md-2 hidden-xs hidden-sm">
					@if(empty($p->image))
						<img class="img-responsive img-thumbnail" src="/images/no_image.jpg" alt="">
					@else
						<img class="img-responsive img-thumbnail" src="/images/encyclopedia/people/{{$p->image}}" alt="">
					@endif
					</div>
					<div class="col-xs-12 col-sm-12 col-md-8">
						<h4>
							<a class="title-name" href="/ecma/personas/{{$p->slug}}">{{$p->name}}</a> <span class="japanese-name">({{$p->japanese_name}})</span>
						</h4>
					</div>
					<div class="col-xs-12 col-sm-12 col-md-8">
						<p class="text-justify">{{str_limit(strip_tags($helper->parseBBCode($p->bio), ''), 170)}} <a class="read-more" href="/ecma/personas/{{str_slug($p->name($p->id))}}">Leer mas</a></p>
						<p class="title-categories">
							<span class="text-strong">Areas/Hobbies/Etc:</span> {{$p->areas_skills_hobbies}}
						</p>
					</div>
					<div class="col-md-2 text-center hidden-xs hidden-sm">
					@if (is_null($p->created_at))
						<span class="post_date">{{$helper->getDate($p->public_time)}}</span>
					@else
						<span class="post_date">{{$helper->getDate(strtotime($p->created_at,0))}}</span>
					@endif
					</div>
				</td>
			</tr>
		@endforeach
		</tbody>
	</table>
	<div class="col-xs-12 col-sm-12 col-md-12 text-center">{{$people->appends(request()->all())->links()}}</div>
</div>
@endsection
