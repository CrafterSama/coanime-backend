<div class="leftbar col-md-2 hidden-xs hidden-sm">
	<ul class="nav nav-pills nav-stacked">
		<li @if(Request::segment(1) == 'dashboard' && Request::segment(2) == '') class="active" @endif><a href="{{ route('admin') }}"><i class="fas fa-home"></i> Inicio</a></li>
		@if(Auth::user()->isAdmin())
		<li @if(Request::segment(2) == 'posts') class="active" @endif><a href="{{ route('db.posts') }}"><i class="fas fa-newspaper"></i> Posts</a></li>
		@endif
		<li @if(Request::segment(2) == 'events') class="active" @endif><a href="{{ route('db.events') }}"><i class="fas fa-calendar"></i> Eventos</a></li>
		<li @if(Request::segment(2) == 'titles') class="active" @endif><a href="{{ route('db.titles') }}"><i class="fas fa-file-invoice"></i> Titulos</a></li>
		<li @if(Request::segment(2) == 'magazine') class="active" @endif><a href="{{ route('db.magazine') }}"><i class="fas fa-book"></i> Revistas</a></li>
		<li @if(Request::segment(2) == 'people') class="active" @endif><a href="{{ route('db.people') }}"><i class="fas fa-id-badge"></i> Personas</a></li>
		<li @if(Request::segment(2) == 'companies') class="active" @endif><a href="{{ route('db.companies') }}"><i class="fas fa-building"></i> Empresas</a></li>
		@if(Auth::user()->isAdmin())
		<li @if(Request::segment(2) == 'users') class="active" @endif><a href="{{ route('users.index') }}"><i class="fas fa-users"></i> Usuarios</a></li>
		@endif
	</ul>
</div>
