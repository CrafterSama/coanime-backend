<nav class="navbar navbar-expand-lg navbar-light bg-white shadow fixed-top">
    <div class="container-lg">
        <a class="navbar-brand" href="/"></a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item active">
                    <a class="nav-link" href="/posts">Articulos <span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Enciclopedia
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="/ecma/titulos">Titulos</a>
                        <a class="dropdown-item" href="/ecma/personas">Personas</a>
                        <a class="dropdown-item" href="/ecma/revistas">Revistas</a>
                        <a class="dropdown-item" href="/ecma/empresas">Empresas</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="/ecma/generos">Generos</a>
                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/eventos">Eventos</a>
                </li>
            </ul>
            <form class="form-inline my-2 my-lg-0">
                <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
                <button class="btn btn-outline-info my-2 my-sm-0" type="submit"><i class="fas fa-search"></i></button>
            </form>
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
                        <ul class="dropdown-menu" role="menu">
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
                @endif
            </ul>
        </div>
    </div>
</nav>
