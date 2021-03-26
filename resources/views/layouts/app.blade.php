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

	{{-- CSRF Token --}}
	<meta name="csrf-token" content="{{ csrf_token() }}">

	<title>
	    {{-- config('app.name', 'ECMA - ') --}}
	    @yield('title')
	</title>
	@if(Request::segment(1) != 'dashboard')
		{{-- Facebook Pixel Code --}}
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
		{{-- End Facebook Pixel Code --}}
	@endif
	{{--  Vendor Styles  --}}
	@if(Request::segment(1) == 'dashboard')
    <link rel="stylesheet" href="/vendor/bootstrap-select/css/bootstrap-select.min.css" />
    <link rel="stylesheet" type="text/css" href="/vendor/selectize/selectize.css" />
	<link rel="stylesheet" href="/vendor/bootstrap-datepicker/css/bootstrap-datetimepicker.min.css" />
	@endif
	@if(Request::segment(1) == 'dashboard' ||  Request::segment(1) == 'posts')
	<link rel="stylesheet" href="/vendor/sweetalert2/sweetalert2.min.css" />
	@endif

	{{-- Favicons, for every posible device --}}
	<link rel="apple-touch-icon" sizes="57x57" href="apple-icon-57x57.png">
	<link rel="apple-touch-icon" sizes="60x60" href="apple-icon-60x60.png">
	<link rel="apple-touch-icon" sizes="72x72" href="apple-icon-72x72.png">
	<link rel="apple-touch-icon" sizes="76x76" href="apple-icon-76x76.png">
	<link rel="apple-touch-icon" sizes="114x114" href="apple-icon-114x114.png">
	<link rel="apple-touch-icon" sizes="120x120" href="apple-icon-120x120.png">
	<link rel="apple-touch-icon" sizes="144x144" href="apple-icon-144x144.png">
	<link rel="apple-touch-icon" sizes="152x152" href="apple-icon-152x152.png">
	<link rel="apple-touch-icon" sizes="180x180" href="apple-icon-180x180.png">
	<link rel="icon" type="image/png" sizes="192x192" href="android-icon-192x192.png">
	<link rel="icon" type="image/png" sizes="32x32" href="favicon-32x32.png">
	<link rel="icon" type="image/png" sizes="96x96" href="favicon-96x96.png">
	<link rel="icon" type="image/png" sizes="16x16" href="favicon-16x16.png">
	<meta name="msapplication-TileColor" content="#ffffff">
	<meta name="msapplication-TileImage" content="ms-icon-144x144.png">
	<meta name="theme-color" content="#ffffff">


    @stack('scripts')

	{{-- REVIEW: Feeds --}}
	{!! Feed::link(url('feed'), 'rss', 'Coanime.net Feeds', 'es') !!}


	{{--
	====================================================================
	NEW SCAFOLDING: CSS
	--------------------------------------------------------------------
	--}}

    {{-- Vendor --}}
    <link href="{{ asset('assets/vendor/bootstrap/css/bootstrap.css') }}" rel="stylesheet">

	{{-- App --}}
	<link href="{{ mix('assets/css/coanime.css') }}" rel="stylesheet">


	{{--
	FIX ME: delete duplicates from the before layout
	====================================================================
	--}}


</head>
<body>
    <div id="app">
        @include('common.navbar')

        <div class="content-box">
            <main class="wrapper">
                @yield('content')
            </main>
        </div>

        @include('common.footer')
    </div>

	{{--
	====================================================================
	NUEVO SCAFOLDING: Scripts
	--------------------------------------------------------------------
	--}}
	<!-- Vendor -->
	<script src="{{ asset('assets/vendor/jquery/js/jquery.js') }}"></script>
	<script src="{{ asset('assets/vendor/popper.js/js/popper.js') }}"></script>
    <script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.js') }}"></script>
    <script src="https://kit.fontawesome.com/ec6f045846.js" crossorigin="anonymous"></script>

	<!-- App -->
	<script src="{{ mix('assets/js/app.js') }}"></script>

	{{--
	FIXME: Eliminar duplicados
	====================================================================
	--}}

	<!-- Scripts -->
	<script defer>
		window.ECMA =  {!! json_encode(['csrfToken' => csrf_token()]) !!}
    </script>
	<script defer src="/vendor/es6-promise/es6-promise.min.js"></script>
	<script src="https://cdn.plyr.io/3.5.2/plyr.polyfilled.js"></script>
	<script defer>
		//const player = new Plyr('#player');
	</script>
	@php
		$d = new DateTime();
	@endphp
	@if($d->format('m-d') >= '12-01' && $d->format('m-d') <= '12-31')
		<script src="/js/nevada.min.js"></script>
	@endif
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
</body>
</html>
