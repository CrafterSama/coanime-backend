<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1">
	<meta name="description" content="@yield('description')" />
	<meta name="author" content="@coanime">
	<meta property="og:locale" content="es_ES" />
    @yield('og_type')
	<meta property="og:site_name" content="Coanime" />
	<meta property="og:title" content="Coanime - @yield('title')" />
	<meta property="og:description" content="@yield('description')" />
	<meta property="og:url" content="{!!Request::url()!!}" />
	<meta property="og:image" content="@yield('twitter-image')">
	<meta property="og:image:secure_url" content="@yield('twitter-image')">
	<meta name="twitter:card" content="summary_large_image">
	<meta name="twitter:description" content="@yield('description')">
	<meta name="twitter:title" content="Coanime - @yield('title')">
	<meta name="twitter:site" content="@coanime">
	<meta name="twitter:image:src" content="@yield('twitter-image')" />
	<meta name="twitter:creator" content="@coanime">
    @yield('tags')
    @yield('section')
    @yield('time')
    <meta name="google-site-verification" content="eIQBLZgWmisXKwYEiGVWty1gOk2YPohgAWQKvGjKEsE" />


	<link rel="canonical" href="{!!Request::url()!!}/" />
	<meta name="referrer" content="default">
	<meta property="fb:pages" content="127729317274121" />
	<meta content='all, index, follow' name='robots' />

	<!-- CSRF Token -->
	<meta name="csrf-token" content="{{ csrf_token() }}">

	<title>
	    {{-- config('app.name', 'ECMA - ') --}}
	    Coanime - @yield('title')
	</title>
	@if(Request::segment(1) != 'dashboard')
		<!— Facebook Pixel Code —>
		<script>
		!function(f,b,e,v,n,t,s)
		{if(f.fbq)return;n=f.fbq=function(){n.callMethod?
		n.callMethod.apply(n,arguments):n.queue.push(arguments)};
		if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
		n.queue=[];t=b.createElement(e);t.async=!0;
		t.src=v;s=b.getElementsByTagName(e)[0];
		s.parentNode.insertBefore(t,s)}(window, document,'script',
		'https://connect.facebook.net/en_US/fbevents.js');
		fbq('init', '135099553998569');
		fbq('track', 'PageView');
		</script>
		<noscript><img height="1" width="1" style="display:none"
		src="https://www.facebook.com/tr?id=135099553998569&ev=PageView&noscript=1"
		/></noscript>
		<!— End Facebook Pixel Code —>
	@endif
	<!--  Vendor Styles  -->
	<link defer rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"/>
	@if(Request::segment(1) == 'dashboard')
    <link rel="stylesheet" href="/assets/vendor/bootstrap-select/css/bootstrap-select.min.css" />
    <link rel="stylesheet" type="text/css" href="/assets/vendor/selectize/selectize.css" />
	<link rel="stylesheet" href="/assets/vendor/bootstrap-datepicker/css/bootstrap-datetimepicker.min.css" />
	@endif
	@if(Request::segment(1) == 'dashboard' ||  Request::segment(1) == 'posts')
	<link rel="stylesheet" href="/assets/vendor/sweetalert2/sweetalert2.min.css" />
	@endif
	<!-- Styles -->
	<link defer href="https://fonts.googleapis.com/css?family=Open+Sans:400,400i,700,700i" rel="stylesheet">
	<link rel="stylesheet" href="https://cdn.plyr.io/3.5.2/plyr.css" />
	<link href="/assets/old/flatfy.min.css" rel="stylesheet" />
	<link href="/assets/old/animate.css" rel="stylesheet" />
	<link href="/assets/old/plyr.css" rel="stylesheet" />
	<link href="/assets/old/style.css" rel="stylesheet">

	<!-- Favicons -->
	<link rel="shortcut icon" href="https://images.coanime.net/content/images/system/favicon_1.47974079578E+12_b1630e.png">
	<link rel="icon" type="image/png" href="https://images.coanime.net/content/images/system/favicon_1.47974079578E+12_b1630e.png" sizes="192x192">
	<link rel="apple-touch-icon" href="https://images.coanime.net/content/images/system/favicon_1.47974079578E+12_b1630e.png" sizes="180x180">
	<script src="https://cdn.jsdelivr.net/npm/lazyload@2.0.0-beta.2/lazyload.js"></script>
	<script>
		let images = document.querySelectorAll(".article-image");
		lazyload(images);
	</script>

	<!-- Feeds -->
	{!!Feed::link(url('feed'), 'rss', 'Coanime.net Feeds', 'es')!!}
</head>
<body>
    <div style="@yield('body')"></div>
    <nav class="navbar navbar-default navbar-fixed-top">
        <div class="container">
            <div class="navbar-header">

                <!-- Collapsed Hamburger -->
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                    <span class="sr-only">Toggle Navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>

                <!-- Branding Image -->
            <a class="navbar-brand" href="http://coanime.net/"><img class="logo-ecma" src="{{ asset('images/home-tipo.svg') }}" alt="{{ config('app.name', 'Coanime') }}" /></a>
            </div>

            <div class="collapse navbar-collapse" id="app-navbar-collapse">
                <!-- Left Side Of Navbar -->
                <ul class="nav navbar-nav">
                    <li><a href="/posts">Blog</a></li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                            Enciclopedia <span class="caret"></span>
                        </a>
                        <ul class="dropdown-menu" role="menu">
                            <li><a href="/ecma/titulos">Titulos</a></li>
                            <li><a href="/ecma/personas">Personas</a></li>
                            <li><a href="/ecma/revistas">Revistas</a></li>
                            <li><a href="/ecma/empresas">Empresas</a></li>
                            <li role="separator" class="divider"></li>
                            <li><a href="/ecma/generos">Generos</a></li>
                        </ul>
                    </li>
                    <li><a href="/eventos">Eventos</a></li>
                </ul>

                <!-- Right Side Of Navbar -->
                <ul class="nav navbar-nav navbar-right">
                    <!-- Authentication Links -->
                    @if (Auth::guest())
                        <li><a href="{{ url('/login') }}">Participa</a></li>
                    @else
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                {{ Auth::user()->name }} <span class="caret"></span>
                            </a>
                            <ul class="dropdown-menu" role="menu">
                                @if(empty(Auth::user()->slug))
                                    <li><a href="{{route('profile', Auth::user()->id)}}"><i class="fas fa-user"></i> Perfil</a></li>
                                @else
                                    <li><a href="{{route('profile', Auth::user()->slug)}}"><i class="fas fa-user"></i> Perfil</a></li>
                                @endif
                                @if(Auth::user()->isAdmin() || Auth::user()->isMod())
                                <li><a href="{{route('admin')}}"><i class="fas fa-tachometer-alt "></i> Dashboard</a></li>
                                @endif
                                @if(Auth::user()->isAdmin())
                                <li><a href="{{route('config')}}"><i class="fas fa-cogs"></i> Configuración</a></li>
                                @endif
                                <li>
                                    <a href="{{ url('/logout') }}"
                                        onclick="event.preventDefault();
                                                    document.getElementById('logout-form').submit();">
                                        <i class="fas fa-sign-out-alt ut"></i> Salir
                                    </a>
                                    <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
                                        {{ csrf_field() }}
                                    </form>
                                </li>
                            </ul>
                        </li>
                    @endif
                </ul>
            </div>
        </div>
    </nav>
    @if(Request::segment(1) == 'dashboard')
    <div class="container-fluid">
    @elseif(Request::segment(1) == 'posts')
    <div class="container-posts">
    @else
    <div class="container">
    @endif
        <main class="wrapper row">
            @yield('content')
        </main>
    </div>
	<!-- /div -->
	<footer class="footer">
        <div class="footer__content">
            <div class="content__items">
                <div class="items__others-links">
                    <p>Síguenos <a href="https://www.facebook.com/Coanime/"><img src="{!! asset('/assets/images/facebook-white.svg') !!}" class="" alt="" /></a> <a href="https://twitter.com/coanime/"><img src="{!! asset('/assets/images/twitter-white.svg') !!}" class="" alt="" /></a> <a href="https://www.instagram.com/coanimenet/"><img src="{!! asset('/assets/images/instagram-white.svg') !!}" class="" alt="" /></a></p>
                </div>
                <div class="items__copyright">
                    <p>&copy; <script>new Date().getFullYear()</script> Coanime. Todos los derechos reservados</p>
                    <p class="footer-links"><a href="/page/terminos-de-uso-y-aviso-legal">Términos de uso y Aviso Legal</a> | <a href="/page/politica-de-privacidad">Politica de Privacidad</a></p>
                </div>
            </div>
        </div>
    </footer>

	<!-- Scripts -->
	<script defer>
		window.ECMA =  {!! json_encode(['csrfToken' => csrf_token()]) !!}
	</script>
	<script src="/assets/vendor/jquery/js/jquery.min.js"></script>
	<script defer src="/assets/vendor/bootstrap/js/bootstrap.min.js"></script>
	<script defer src="/assets/vendor/es6-promise/es6-promise.min.js"></script>
	<script defer src="/assets/vendor/timeago/jquery.timeago.js"></script>
	<script defer src="/assets/vendor/timeago/jquery.timeago.es.js"></script>
	<script src="https://cdn.plyr.io/3.5.2/plyr.polyfilled.js"></script>
	<script defer>
		const players = Array.from(document.querySelectorAll('.plyrs'));

		players.map(player => new Plyr(player));

    players.forEach(function(player) {
        window.addEventListener("load", function() {
            //player.pause();
            setTimeout(() => { player.pause() }, 10);
        })
    });
	</script>
    <script defer src="https://use.fontawesome.com/releases/v5.7.2/js/all.js"></script>
	@if(Request::segment(1) == 'dashboard')
		<script defer src="/assets/vendor/bootstrap-validator/validator.min.js"></script>
		<script defer src="/assets/vendor/moment/moment.min.js"></script>
		<script defer src="/assets/vendor/bootstrap-datepicker/js/bootstrap-datetimepicker.min.js"></script>
        <script defer src="/assets/vendor/bootstrap-select/js/bootstrap-select.min.js"></script>
        <script type="text/javascript" src="/assets/vendor/selectize/selectize.js"></script>
		<script defer src="/assets/vendor/tinymce/tinymce.min.js"></script>
	@endif
	@if( Request::segment(1) == 'posts' ||  Request::segment(1) == 'dashboard')
		<script src="/assets/vendor/sweetalert2/sweetalert2.js"></script>

		@include('sweet::alert')
		@include('dashboard.partials.tinymce')
	@endif
	@if(Request::segment(1) == 'dashboard' || Request::segment(1) == 'register')
		@include('dashboard.partials.scripts')
	@endif
	<script defer src='https://www.google.com/recaptcha/api.js'></script>
	@php
		$d = new DateTime();
	@endphp
	@if($d->format('m-d') >= '12-01' && $d->format('m-d') <= '12-31')
		<script src="/assets/old/nevada.min.js"></script>
	@endif
	<script src="/assets/old/jquery.slides.min.js"></script>
	<script src="/assets/old/imagesloaded.pkgd.js"></script>
	<script src="/assets/old/masonry.pkgd.js"></script>
	<!-- script src="/assets/old/jaliswall.js"></script -->
	<script src="/assets/old/scripts.js"></script>
	@if(Request::segment(2) == 'titulos')
		@include('partials.scripts')
	@endif
@if(Request::segment(1) != 'dashboard')
	<!-- Facebook SDK -->
	<div id="fb-root"></div>
	<script defer async>
		(function(d, s, id) {
		var js, fjs = d.getElementsByTagName(s)[0];
		if (d.getElementById(id)) return;
		js = d.createElement(s); js.id = id;
		js.src = "//connect.facebook.net/es_LA/sdk.js#xfbml=1&version=v2.7&appId=439547086253998";
		fjs.parentNode.insertBefore(js, fjs);
		}(document, 'script', 'facebook-jssdk'));
	</script>
    <!-- / Facebook SDK -->
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-4744745-2"></script>
    <script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());

    gtag('config', 'UA-4744745-2', { 'optimize_id': 'GTM-N7QFN59'});
    </script>
    <!-- / Global site tag (gtag.js) - Google Analytics -->
    <script data-ad-client="ca-pub-4955562843486224" async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
	<!-- Twitter Widget -->
	<script>
		window.twttr = (function(d, s, id) {
			var js, fjs = d.getElementsByTagName(s)[0],
				t = window.twttr || {};
			if (d.getElementById(id)) return t;
			js = d.createElement(s);
			js.id = id;
			js.src = "https://platform.twitter.com/widgets.js";
			fjs.parentNode.insertBefore(js, fjs);

			t._e = [];
			t.ready = function(f) {
				t._e.push(f);
			};

			return t;
		}(document, "script", "twitter-wjs"));
	</script>
    <!-- / End Twitter Widget -->
@endif
</body>
</html>
