<nav class="navbar navbar-expand-lg navbar-light bg-white shadow fixed-top">
    <div class="container-lg">
        <a class="navbar-brand mr-5" href="/"></a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse justify-content-between" id="navbarSupportedContent">
            <ul class="navbar-nav m-auto-right d-flex justify-content-start">
                {{-- <li class="nav-item pr-4 mr-5 active">
                    <a class="nav-link" href="/posts">Articulos</a>
                </li>
                <li class="nav-item pr-4 mr-5">
                    <a class="nav-link" href="/eventos">Eventos</a>
                </li> --}}
                <li class="nav-item dropdown">
                    <a class="nav-link" href="/ecma/titulos">Enciclopedia</a>
                </li>
            </ul>
            @if(Request::segment(1) == '')
            {{-- <div class="navbar-right d-flex">
                <form class="form-inline my-2 my-lg-0">
                    <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
                    <button class="btn btn-outline-info my-2 my-sm-0" type="submit"><i class="fas fa-search"></i></button>
                </form>
                @endif
                <ul class="nav navbar-nav navbar-right">
                    <!-- Authentication Links -->
                    @if (Auth::guest())
                        <li class="nav-item">
                            <a class="nav-link" href="{{ url('/login') }}">Participa</a>
                        </li>
                    @else
                        <li class="nav-item dropdown">
                            <a class="nav-link" dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                {{ Auth::user()->name }}
                            </a>
                            <ul class="dropdown-menu shadow" role="menu">
                                @if(empty(Auth::user()->slug))
                                    <a class="dropdown-item" href="{{route('profile', Auth::user()->id)}}"><i class="fas fa-user"></i> Perfil</a>
                                @else
                                    <a class="dropdown-item" href="{{route('profile', Auth::user()->slug)}}"><i class="fas fa-user"></i> Perfil</a>
                                @endif
                                @if(Auth::user()->isAdmin() || Auth::user()->isMod())
                                    <a class="dropdown-item" href="{{route('admin')}}"><i class="fas fa-tachometer-alt "></i> Dashboard</a>
                                @endif
                                @if(Auth::user()->isAdmin())
                                    <a class="dropdown-item" href="{{route('config')}}"><i class="fas fa-cogs"></i> Configuración</a>
                                @endif
                                <a class="dropdown-item" href="{{ url('/logout') }}"
                                    onclick="event.preventDefault();
                                    document.getElementById('logout-form').submit();">
                                    <i class="fas fa-sign-out-alt ut"></i> Salir
                                </a>
                                <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
                                    {{ csrf_field() }}
                                </form>
                            </ul>
                        </li>
                    </ul>
                </div> --}}
            @endif
        </div>
    </div>
</nav>
@if(Request::segment(1) === 'ecma')
    <div class="ecma-navigation">
        <div class="container">
            <ul class="nav nav-tabs">
                <li class="nav-item">
                    <a class="{{ Request::segment(2) === 'titulos' ? 'nav-link active' : 'nav-link' }}" href="/ecma/titulos">
                        <span title="Titulos" class="mobile"><i class="fa fa-film"></i></span>
                        <span class="desktop-and-tablet">Titulos</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="{{ Request::segment(2) === 'personas' ? 'nav-link active' : 'nav-link' }}" href="/ecma/personas">
                        <span title="Personas" class="mobile"><i class="fa fa-users"></i></span>
                        <span class="desktop-and-tablet">Personas</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="{{ Request::segment(2) === 'revistas' ? 'nav-link active' : 'nav-link' }}" href="/ecma/revistas">
                        <span title="Revistas" class="mobile"><i class="fa fa-book"></i></span>
                        <span class="desktop-and-tablet">Revistas</span>
                    </a>
                </li>
                {{-- <li class="nav-item">
                    <a class="{{ Request::segment(2) === 'empresas' ? 'nav-link active' : 'nav-link' }}" href="/ecma/empresas">
                        Empresas
                    </a>
                </li> --}}
            </ul>
        </div>
    </div>
@endif
