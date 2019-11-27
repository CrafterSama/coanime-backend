@inject('helper', ' \App\Helper')
@inject('carbon', 'Carbon\Carbon')

@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="home-encyclopedia col-md-12">
	@include('dashboard.partials.top-title')
	<div class="row encyclopedia-body">
		@include('dashboard.partials.leftbar')
		<!-- Tab panes -->
		<div class="col-md-10 dashboard">
			<!-- Posts -->
			<div class ="titles-section col-md-12">
				<h3 class="other-info-title col-md-12">Ultimos Posts Agregados</h3>
				<div class="top-action-buttons"><a href="{{ route('posts.create') }}" class="btn btn-warning btn-sm"><i class="fas fa-plus"></i>&nbsp; Agregar Post</a> - <a href="{{ route('db.posts') }}" class="btn btn-default btn-sm">Lista de Posts &nbsp; <i class="fas fa-chevron-right"></i></a></div>
				@foreach($posts as $post)
				<div class="events col-md-2">
					<div class="posts-wrapper">
						<div class="post">
							<div class="post-header">
							@if($post->image)
								<div class="titles-top-image"  style="background-image: url(/../../images/posts/{{$post->image}});">
							@else
								<div class="titles-top-image"  style="background-image: url({{$helper->img_post($post->content)}});">
							@endif
									<div class="title-caption">
                                        @php
                                            if($post->category_id == 10):
                                                $postSlug = '/page';
                                            else:
                                                $postSlug = route('blog');
                                            endif;
                                        @endphp
										<a href="{{$postSlug}}/{{ $post->slug }}">
											<h3 class="titles-name text-center">{{$post->title}}</h3>
											<div class="post-excerpt">
												{{$helper->excerpt(strip_tags($helper->textWithoutImage($post->content)), 60)}}
											</div>
										</a>
									</div>
								</div>
							</div>
							<div class="titles-details text-right">
								<span class="post-author"><i class="fas fa-user"></i> {{$post->users->name}}</span>
								@if ($post->postponed_to == $post->created_at || is_null($post->postponed_to))
									@if (is_null($post->created_at))
										<i class="fas fa-calendar"></i>&nbsp;<time class="post-date timeago" datetime="{{$carbon->parse($post->post_created_at)->format('Y-m-d H:i:s')}}" title=""></time>
									@else
										<i class="fas fa-calendar"></i>&nbsp;<time class="post-date timeago" datetime="{{$carbon->parse($post->created_at)->format('Y-m-d H:i:s')}}" title=""></time>
									@endif
								@else
									<i class="fas fa-calendar"></i>&nbsp;<time class="post-date timeago" datetime="{{$carbon->parse($post->postponed_to)->format('Y-m-d H:i:s')}}" title=""></time>
								@endif
								<span class="edit-button-box">
									<a href="{{route('posts.edit', $post->id)}}" title="Editar" class="btn-info btn-xs"><i class="fas fa-pen"></i></a>
									<a id="delete-data-{{$post->id}}-submit" onclick="proceed({!!$post->id!!});" class="btn-danger btn-xs"><i class="fas fa-trash"></i></a>
									{!! Form::open(['route' => ['posts.destroy', $post->id], 'method' => 'DELETE', 'class' => 'form-horizontal', 'id' => 'delete-data-'.$post->id]) !!}
									{!! Form::close() !!}
								</span>
								<span class="post-category"><i class="fas fa-tags"></i> {{$post->categories->name}}</span>
							</div>
						</div>
					</div>
				</div>
				@endforeach
				<div class="titles-section-footer col-md-12 text-right"><a href="{{ route('db.posts') }}" class="btn btn-default">Lista de Posts <i class="fas fa-chevron-right"></i></a></div>
			</div>
			<!-- Events -->
			<div class ="titles-section col-md-12">
				<h3 class="other-info-title col-md-12">Ultimos Eventos Agregados</h3>
				<div class="top-action-buttons"><a href="{{ route('events.create') }}" class="btn btn-warning btn-sm"><i class="fas fa-plus"></i> Agregar Evento</a> - <a href="{{ route('db.events') }}" class="btn btn-default btn-sm">Todos los Eventos &nbsp;<i class="fas fa-chevron-right"></i></a></div>
				@foreach($events as $event)
				<div class="events col-md-2">
					<div class="items-boxes">
						@if(empty($event->image))
						<div class="titles-top-image" style="background-image: url(/images/no_image.jpg);">
						@else
						<div class="titles-top-image" style="background-image: url(/images/events/{{$event->image}});">
						@endif
							<div class="title-caption">
								<a href="/eventos/{{$event->slug}}">
									<h3 class="titles-name text-center">{{$event->name}}</h3>
									<div class="titles-body text-justify">
										{!!str_limit(strip_tags($event->description), 160)!!}
									</div>
								</a>
							</div>
						</div>
						<div class="titles-details text-right">
							<span class="post-date">
								<i class="fas fa-map-marker-alt "></i>{{$event->country->name}}
							</span>
							<span class="edit-button-box">
								<a href="{{route('events.edit', $event->id)}}" class="btn-info btn-xs"><i class="fas fa-pen"></i></a>
							</span>
						</div>
					</div>
				</div>
				@endforeach
				<div class="titles-section-footer col-md-12 text-right"><a href="{{ route('db.events') }}" class="btn btn-default">Lista de Eventos <i class="fas fa-chevron-right"></i></a></div>
			</div>
			<!-- Titles -->
			<div class="titles-section col-md-12">
				<h3 class="other-info-title col-md-12">Ultimos Titulos Agregados</h3>
				<div class="top-action-buttons"><a href="{{ route('titles.create') }}" class="btn btn-warning btn-sm"><i class="fas fa-plus"></i> Agregar Titulo</a> - <a href="{{ route('db.titles') }}" class="btn btn-default btn-sm">Lista de Titulos &nbsp; <i class="fas fa-chevron-right"></i></a></div>
				@foreach($titles as $title)
				<div class="events col-md-2">
					<div class="items-boxes">
						@if(empty($title->images->name))
						<div class="titles-top-image" style="background-image: url(/images/no_image.jpg);">
						@else
						<div class="titles-top-image" style="background-image: url(/images/encyclopedia/titles/{{$title->images->name}});">
						@endif
							<div class="title-caption">
								<a href="{{ route('titles') }}/{{strtolower($title->type->name)}}/{{$title->slug}}">
									<h3 class="titles-name text-center">{{$title->name}}</h3>
									<div class="titles-body text-justify">
										{{str_limit(strip_tags($title->sinopsis), 160)}}
									</div>
								</a>
							</div>
						</div>
						<div class="titles-details text-right">
							@if($title->type->slug == 'tv')
							<span class="orange post-date"><i class="fas fa-tv"></i> {{$title->type->name}}</span>
							@elseif($title->type->slug == 'manga')
							<span class="green post-date"><i class="fas fa-book"></i> {{$title->type->name}}</span>
							@elseif($title->type->slug == 'pelicula')
							<span class="cyan post-date"><i class="fas fa-film"></i> {{$title->type->name}}</span>
							@elseif($title->type->slug == 'ova')
							<span class="red post-date"><i class="fas fa-video"></i> {{$title->type->name}}</span>
							@elseif($title->type->slug == 'ona')
							<span class="red post-date"><i class="fas fa-video"></i> {{$title->type->name}}</span>
							@elseif($title->type->slug == 'manhwa')
							<span class="gray post-date"><i class="fas fa-book"></i> {{$title->type->name}}</span>
							@elseif($title->type->slug == 'manhua')
							<span class="cyan post-date"><i class="fas fa-film"></i> {{$title->type->name}}</span>
							@elseif($title->type->slug == 'live-action')
							<span class="purple post-date"><i class="fas fa-users"></i> {{$title->type->name}}</span>
							@elseif($title->type->slug == 'juegos')
							<span class="purple post-date"><i class="fas fa-pad"></i> {{$title->type->name}}</span>
							@elseif($title->type->slug == 'dorama')
							<span class="purple post-date"><i class="fas fa-tv"></i> {{$title->type->name}}</span>
							@elseif($title->type->slug == 'novela-ligera')
							<span class="purple post-date"><i class="fas fa-book"></i> {{$title->type->name}}</span>
							@endif
							<span class="edit-button-box">
								<a href="{{route('titles.edit', $title->id)}}" class="btn-info btn-xs"><i class="fas fa-pen"></i></a>
							</span>
						</div>
					</div>
				</div>
				@endforeach
				<div class="titles-section-footer col-md-12 text-right"><a href="{{ route('db.titles') }}" class="btn btn-default">Titulos <i class="fas fa-chevron-right"></i></a></div>
			</div>
			<!-- Magazine -->
			<div class="titles-section col-md-12">
				<h3 class="other-info-title col-md-12">Ultimos Revistas Agregadas</h3>
				<div class="top-action-buttons"><a href="{{ route('magazine.create') }}" class="btn btn-warning btn-sm"><i class="fas fa-plus"></i> Agregar Revista</a> - <a href="{{ route('db.magazine') }}" class="btn btn-default btn-sm">Lista de Revistas &nbsp; <i class="fas fa-chevron-right"></i></a></div>
				@foreach($magazine as $mgz)
				<div class="events col-md-2">
					<div class="items-boxes">
						@if(empty($mgz->image->name))
							<div class="titles-top-image" style="background-image: url(/images/no_image.jpg);">
						@else
							<div class="titles-top-image" style="background-image: url(/images/encyclopedia/magazine/{{$mgz->image->name}});">
						@endif
							<div class="title-caption">
								<a href="{{ route('magazine') }}/{{$mgz->slug}}">
									<h3 class="titles-name text-center cyan-background"><a href="{{ route('magazine') }}/{{$mgz->slug}}">{{$mgz->name}}</a></h3>
									<div class="titles-body text-justify">
										{{str_limit(strip_tags($mgz->about), 150)}} <a href="{{ route('magazine') }}/{{$mgz->slug}}">Leer mas</a>
									</div>
								</a>
							</div>
						</div>
						<div class="titles-details text-right">
							@if($mgz->type->name == 'Shōjo')
							<span class="orange post-date"><i class="fas fa-book"></i> {{$mgz->type->name}}</span>
							@elseif($mgz->type->name == 'Shōnen')
							<span class="green post-date"><i class="fas fa-book"></i> {{$mgz->type->name}}</span>
							@elseif($mgz->type->name == 'Seinen')
							<span class="cyan post-date"><i class="fas fa-book"></i> {{$mgz->type->name}}</span>
							@elseif($mgz->type->name == 'Josei')
							<span class="red post-date"><i class="fas fa-book"></i> {{$mgz->type->name}}</span>
							@elseif($mgz->type->name == 'Kodama')
							<span class="red post-date"><i class="fas fa-book"></i> {{$mgz->type->name}}</span>
							@endif
							<span class="edit-button-box">
								<a href="{{route('magazine.edit', $mgz->id)}}" class="btn-info btn-xs"><i class="fas fa-pen"></i></a>
							</span>
						</div>
					</div>
				</div>
				@endforeach
				<div class="titles-section-footer col-md-12 text-right"><a href="{{ route('db.magazine') }}" class="btn btn-default">Revistas <i class="fas fa-chevron-right"></i></a></div>
			</div>
			<!-- People -->
			<div class="titles-section col-md-12">
				<h3 class="other-info-title col-md-12">Ultimas Personas Agregadas</h3>
				<div class="top-action-buttons"><a href="{{ route('people.create') }}" class="btn btn-warning btn-sm"><i class="fas fa-plus"></i> Agregar Persona</a> - <a href="{{ route('db.people') }}" class="btn btn-default btn-sm">Lista de Personas &nbsp; <i class="fas fa-chevron-right"></i></a></div>
				@foreach($people as $p)
				<div class="events col-md-2">
					<div class="items-boxes">
						@if(empty($p->image))
						<div class="titles-top-image" style="background-image: url(/images/no_image.jpg);">
						@else
						<div class="titles-top-image" style="background-image: url(/images/encyclopedia/people/{{$p->image}});">
						@endif
							<div class="title-caption">
								<a href="{{ route('people') }}/{{$p->slug}}">
									<h3 class="titles-name text-center"><a href="{{ route('people') }}/{{$p->slug}}">{{$p->name}}</a></h3>
									<div class="titles-body text-justify">
										{{str_limit(strip_tags($p->bio), 160)}} <a href="{{ route('people') }}/{{$p->slug}}">Leer mas</a>
									</div>
								</a>
							</div>
						</div>
						<div class="titles-details text-right">
							<span class="edit-button-box">
								<a href="{{route('people.edit', $p->id)}}" class="btn-info btn-xs"><i class="fas fa-pen"></i></a>
							</span>
						</div>
					</div>
				</div>
				@endforeach
				<div class="titles-section-footer col-md-12 text-right"><a href="{{route('db.people')}}" class="btn btn-default">Personas <i class="fas fa-chevron-right"></i></a></div>
			</div>
			<!-- Companies -->
			<div class="titles-section col-md-12">
				<h3 class="other-info-title col-md-12">Ultimas Empresas Agregadas</h3>
				<div class="top-action-buttons"><a href="{{ route('companies.create') }}" class="btn btn-warning btn-sm"><i class="fas fa-plus"></i> Agregar Empresa</a> - <a href="{{ route('db.companies') }}" class="btn btn-default btn-sm">Lista de Empresas &nbsp; <i class="fas fa-chevron-right"></i></a></div>
				@foreach($companies as $company)
				<div class="events col-md-2">
					<div class="items-boxes">
						@if(empty($p->image))
						<div class="titles-top-image" style="background-image: url(/images/no_image.jpg);">
						@else
						<div class="titles-top-image" style="background-image: url(/images/encyclopedia/companies/{{$company->image}});">
						@endif
							<div class="title-caption">
								<a href="{{ route('companies') }}/{{$company->slug}}">
									<h3 class="titles-name text-center"><a href="{{route('companies')}}/{{$company->slug}}">{{$company->name}}</a></h3>
									<div class="titles-body text-justify">
										{{str_limit(strip_tags($company->about), 160)}} <a href="{{route('companies')}}/{{$company->slug}}">Leer mas</a>
									</div>
								</a>
							</div>
						</div>
						<div class="titles-details text-right">
							<span class="edit-button-box">
								<a href="{{route('companies.edit', $company->id)}}" class="btn-info btn-xs"><i class="fas fa-pen"></i></a>
							</span>
						</div>
					</div>
				</div>
				@endforeach
				<div class="titles-section-footer col-md-12 text-right"><a href="{{route('db.companies')}}" class="btn btn-default">Empresas <i class="fas fa-chevron-right"></i></a></div>
			</div>
		</div>
	</div>
</div>
@endsection
