@if(Request::segment(1) == 'dashboard')
<div class="container-fluid">
	<div style="margin-bottom: 0px; border-radius: 0px" class="breadcrumb row">
@else
<div class="container">
	<div class="breadcrumb row">
@endif
		<div class="btn-group btn-breadcrumb">
			<a href="/" class="btn btn-default"><i class="fa fa-home"></i></a>
			@php
				$bread = URL::to('/');
				$link = Request::path();
				$subs = explode("/", $link);
			@endphp

			@if (Request::path() != '/')

			  @for($i = 0; $i < count($subs); $i++)

				@php
				  $bread = $bread."/".$subs[$i];
				  $title = urldecode($subs[$i]);
				  $title = str_replace("-", " ", $title);
				  $title = title_case($title);
				@endphp

				<a href="{{ $bread }}" class="btn btn-default">{{ $title }}</a>

			  @endfor

			@endif
		</div>
	</div>
</div>