@inject('helper', 'App\Helper')

@section('title', 'Perfil de ' . $user->name )
@section('description', 'Datos Compartidos por el Usuario ' . $user->name )
@section('twitter-image', 'https://coanime.net/images/profiles/' . $user->image )

@extends('layouts.app')

@section('content')
<div class="title-details col-md-12">
	<h3 class="title-name text-center purple-background col-md-12"><a href="" onclick="history.back()" class="btn btn-warning btn-sm pull-left"><i class="fas fa-chevron-left"></i> Volver</a> {{$user->name}} </h3>
	<div class="title-top-image hidden-md hidden-lg" @if(empty($user->image)) style="background-image: url(/images/no_image.jpg);" @else style="background-image: url(/images/profiles/thumb-{{$user->image}});" @endif></div>

	<div class="title-info col-md-9">
		<div role="tabpanel">
			<!-- Nav tabs -->
			<ul class="nav nav-tabs" role="tablist">
				<li role="presentation" class="active">
					<a href="#home" aria-controls="home" role="tab" data-toggle="tab">Informacion</a>
				</li>
			</ul>
			<!-- Tab panes -->
			<div class="tab-content">
				<div role="tabpanel" class="tab-pane active" id="home">
					<div class="other-info">
						<h4 class="sub-title-info">
							Datos Personales Conocidos
							@if(Auth::guest() == false)
								@if(Auth::user()->isAdmin() || Auth::user()->isMod())
									<a class="btn btn-warning btn-xs pull-right" href="{{ route('users.edit', $user->id) }}" >Editar Perfil</a>
								@else
									<a class="btn btn-warning btn-xs pull-right" href="{{ route('users.edit', Auth::user()->id) }}" >Editar Perfil</a>
								@endif
							@endif
						</h4>
						<div>
							<span class="text-strong">Nombre Completo:</span> <span class="text-italic">{{$user->name}}</span>
						</div>
						<div>
							@if($user->birthday == NULL || $user->birthday == '0000-00-00')
								<span class="text-strong">Fecha de Nacimiento:</span> <span class="text-italic">Desconocida</span>
							@else
								<span class="text-strong">Fecha de Nacimiento:</span> <span class="text-italic">{{$user->birthday->format('d/m/Y')}}</span>
							@endif
						</div>
						<div>
							<span class="text-strong">Genero:</span>
							<span class="text-italic">
								@if($user->genre == 0)
									Femenino
								@else
									Masculino
								@endif
							</span>
						</div>
						<div>
							<span class="text-strong">Nick/Apodo:</span>
							<span class="text-italic">
								@if(!empty($user->nick))
									{{ $user->nick }}
								@else
									Nick o Apodo Desconocido
								@endif
							</span>

						</div>
					</div>
					<div class="sinopsis text-justify">
						<h4 class="sub-title-info">Bio Conocida</h4>
						{!! $helper->parseBBCode($user->bio) !!}
					</div>
					<div class="sinopsis social-networks">
						<h4 class="sub-title-info social-links">Redes Sociales</h4>
						@if(!empty($user->twitter))
							<a rel="nofollow" target="_blank" href="https://twitter.com/{{ $user->twitter }}" title="{{ $user->name }} en Twitter"><i class="fab fa-twitter fa-lg"></i></a>
						@endif
						@if(!empty($user->facebook))
							<a rel="nofollow" target="_blank" href="https://facebook.com/{{ $user->facebook }}" title="{{ $user->name }} en Facebook"><i class="fab fa-facebook fa-lg"></i></a>
						@endif
						@if(!empty($user->googleplus))
							<a rel="nofollow" target="_blank" href="https://plus.google.com/+{{ $user->googleplus }}" title="{{ $user->name }} en Google+"><i class="fab fa-google-plus-g fa-lg"></i></a>
						@endif
						@if(!empty($user->behance))
							<a rel="nofollow" target="_blank" href="https://www.behance.net/{{ $user->behance }}" title="{{ $user->name }} en Behance"><i class="fab fa-behance fa-lg"></i></a>
						@endif
						@if(!empty($user->pinterest))
							<a rel="nofollow" target="_blank" href="https://pinterest.com/{{ $user->pinterest }}" title="{{ $user->name }} en Pinterest"><i class="fab fa-pinterest fa-lg"></i></a>
						@endif
						@if(!empty($user->deviantart))
							<a rel="nofollow" target="_blank" href="https://{{ $user->deviantart }}.deviantart.com/" title="{{ $user->name }} en DeviantArt"><i class="fab fa-deviantart fa-lg"></i></a>
						@endif
						@if(!empty($user->tumblr))
							<a rel="nofollow" target="_blank" href="https://{{ $user->tumblr }}.tumblr.com/" title="{{ $user->name }} en Tumblr"><i class="fab fa-tumblr fa-lg"></i></a>
						@endif
						@if(!empty($user->instagram))
							<a rel="nofollow" target="_blank" href="https://instagram.com/{{ $user->instagram }}" title="{{ $user->name }} en Instagram"><i class="fab fa-instagram fa-lg"></i></a>
						@endif
						@if(!empty($user->website))
							<a rel="nofollow" target="_blank" href="http://{{ $user->website }}/" title="Sitio web de {{ $user->name }}"><i class="fab fa-external-link-square fa-lg"></i></a>
						@endif
					</div>
					<div class="sinopsis">
						<h4 class="sub-title-info">Ultimas 10 Notas de {{ $user->posts->where('draft','0')->count() }} Notas Publicadas</h4>
						@foreach($user->posts->where('draft','0')->take(10) as $post)
							<h5 class="user-last-post-title">
								@php
									setlocale(LC_TIME, 'Spanish_Venezuela');
								@endphp
								<a href="{{ route('blog').'/'.$post->slug }}">{{ $post->title }}</a> el {{ $helper->setSpanishDate($post->postponed_to->format('l, d M Y \a \l\a\s h:i:s a')) }}
							</h5>
						@endforeach
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="sidebar col-md-3 hidden-xs hidden-sm">
		@if(empty($user->image))
			<img class="img-responsive" src="/images/no_image.jpg" alt="">
		@else
			<img class="img-responsive" src="{{$user->image}}" alt="">
		@endif
	</div>
</div>
@endsection
