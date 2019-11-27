@inject('helper', 'App\Helper')
@inject('carbon', 'Carbon\Carbon')

@extends('layouts.app')

@section('title', 'Lista de Posts')

@section('content')

@include('dashboard.partials.top-title')

@include('dashboard.partials.leftbar')

<div class="lists col-md-10">
	<div class="row">
		@include('partials.searchbox')
		<div class="search-box col-md-12">
			<a href="{{route('posts.create')}}" class="btn btn-warning btn-sm"><i class="fa fa-plus"></i> Agregar Post</a>
		</div>
	</div>
	<table class="table table-rounded table-striped table-condensed cf">
		<thead>
			<tr>
				<th>
					<div class="col-xs-4 col-sm-4 col-md-4">Imagen y Titulo del Articulo</div>
					<div class="col-xs-2 col-sm-2 col-md-2 text-center hidden-xs hidden-sm">Detalles </div>
					<div class="col-xs-1 col-sm-1 col-md-1 text-center hidden-xs hidden-sm">Creado </div>
					<div class="col-xs-1 col-sm-1 col-md-2 text-center hidden-xs hidden-sm">Publicado Para </div>
					<div class="col-xs-4 col-sm-4 col-md-3 text-center">Acciones</div>
				</th>
			</tr>
		</thead>
		<tbody>
		@foreach($posts as $post)
			<tr>
				<td>
					<div class="col-xs-6 col-sm-6 col-md-4">
                        @php
                            if($post->category_id == 10):
                                $postSlug = '/page';
                            else:
                                $postSlug = route('blog');
                            endif;
                        @endphp
                        @if($post->image)
                            <img class="col-md-4" src="{!! asset('images/posts/thumbnails/thumb-'. str_replace('1920','320', $post->image)) !!}" alt="{{ $post->title }} - Coanime">
                        @else
                            <img class="col-md-4" src="{{$helper->img_post($post->content)}}" alt="{{ $post->title }} - Coanime">
                        @endif
						<p class="col-md-8"><a href="{{$postSlug}}/{{$post->slug}}">{{$post->title}}</a></p>
					</div>
					<div class="col-md-2 text-center hidden-xs hidden-sm">
						<div>Autor: {{$post->users->name}}</div>
						<div>Categoria: {{$post->categories->name}}</div>
						<div>Vistas: {{$post->view_counter}}</div>
					</div>
					<div class="col-md-1 text-center hidden-xs hidden-sm">
					@if (is_null($post->created_at))
						<i class="fa fa-calendar"></i>&nbsp;<time class="post_date timeago" datetime="{{$carbon->parse($post->post_created_at)->format('Y-m-d H:i:s')}}" title=""></time>
					@else
						<i class="fa fa-calendar"></i>&nbsp;<time class="post_date timeago" datetime="{{$carbon->parse($post->created_at)->format('Y-m-d H:i:s')}}" title=""></time>
					@endif
					</div>
					<div class="col-md-2 text-center hidden-xs hidden-sm">
						@if(is_null($post->postponed_to))
							Sin Programar
						@else
							<i class="fa fa-calendar"></i>&nbsp;<time class="post_date timeago" datetime="{{$carbon->parse($post->postponed_to)->format('Y-m-d H:i:s')}}" title=""></time>
						@endif
					</div>
					<div class="col-xs-3 col-sm-6 col-md-3 text-center">
						@if(Auth::user()->id == $post->users->id || Auth::user()->isAdmin() || Auth::user()->isMod())
							<a href="{{ route('posts.edit', $post->id) }}" class="btn btn-info btn-sm"><i class="fa fa-edit"></i> Editar</a>
						@endif
						@if(Auth::user()->id == $post->users->id || Auth::user()->isAdmin())
							<a id="delete-data-{{$post->id}}-submit" onclick="proceed({!!$post->id!!});" class="btn btn-danger btn-sm"><i class="fa fa-trash-o"></i> &nbsp;Borrar</a>
							{!! Form::open(['route' => ['posts.destroy', $post->id], 'method' => 'DELETE', 'class' => 'form-horizontal', 'id' => 'delete-data-'.$post->id]) !!}
							{!! Form::close() !!}
						@endif
					</div>
				</td>
			</tr>
		@endforeach
		</tbody>
	</table>
	<div class="col-xs-12 col-sm-12 col-md-12 text-center">{{$posts->appends(request()->all())->links()}}</div>
</div>
@endsection
