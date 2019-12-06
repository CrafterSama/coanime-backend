@inject('helper', 'App\Helper')
@inject('carbon', 'Carbon\Carbon')

{{-- Head Info --}}

@section('title', $post->categories->name.' - '.$post->title)

@section('description', $helper->excerpt($helper->textWithoutImage(strip_tags($post->content))) . '...')

@section('og_type')
    <meta property="og:type" content="article" />
@endsection

@section('twitter-image', 'https://coanime.net/images/posts/'. $post->image)

@section('tags')
    <meta property="article:publisher" content="http://www.facebook.com/Coanime">
    @foreach($post->tags as $t)
        <meta property="article:tag" content="{{ $t->name }}" />
    @endforeach
@endsection

@section('section')
    <meta property="article:section" content="{{ $post->categories->name }}" />
@endsection

@section('time')
    @if ($post->postponed_to !== null)
        <meta property="article:published_time" content="{{ $post->postponed_to->format('c') }}" />
    @else
        <meta property="article:published_time" content="{{ $post->created_at->format('c') }}" />
    @endif
@endsection

{{-- /End Head Info --}}

@section('body', 'background-image: linear-gradient(rgba(255, 255, 255,0) 64%, rgba(255, 255, 255,100) 96%),url(https://coanime.net/images/posts/' . $post->image . '); height: 60vh; background-position: center; background-repeat:
no-repeat; background-size: cover; position: absolute; top: 0; left: 0;width: 100%; filter: blur(8px); opacity: .95; -webkit-transform: scale(1.05); transform: scale(1.05);')
@extends('layouts.app')
@section('content')
<div class="post-content col-md-12" id="post-article" data-id="{{ $post->id }}">
    <div class="posts-wrapper col-md-12">
        <div class="post-inside">
            <div class="post-top-image">
                @if(Auth::guest() == false)
                    @if(Auth::user()->isAdmin() || Auth::user()->isMod())
                        <span><a href="/dashboard/posts/{{$post->id}}/edit" class="btn btn-info btn-sm" data-container="body" data-toggle="tooltip" data-placement="top" title="Editar"><i class="fas fa-pencil"></i></a></span>
                    @endif
                @endif
                @if($post->image)
                    <img class="arcticle-top-image" srcset="{{str_replace('1920','480', $post->image)}} 480w, {{str_replace('1920','640', $post->image)}} 640w, {{str_replace('1920','800', $post->image)}} 800w, {{str_replace('1920','1200', $post->image)}} 1200w, {{str_replace('1920','1600', $post->image)}} 1600w, {{ $post->image}} 1920w" src="{!!  $post->image !!}" alt="{{ $post->title }} - Coanime">
                @else
                    <img src="{{$helper->img_post($post->content)}}" alt="{{ $post->title }} - Coanime">
                @endif
            </div>
            <div class="post-details">
                <a href="/categorias/{{ $post->categories->slug }}"><span class="post-category" rel="section">{{ $post->categories->name }}</span></a>
                <h1 class="post-title-details">{{ $post->title }}</h1>
                <h2 class="post-subtitle">{{ $post->excerpt }}</h2>
                <span class="post-author"><a href="{{ route('profile',$post->users->slug) }}">{{ $post->users->name }}</a></span>
                @if ($post->postponed_to == $post->created_at || is_null($post->postponed_to))
                    @if (is_null($post->created_at))
                        <time-ago>{{$post->post_crated_at}}</time-ago>
                    @else
                        <time-ago>{{$post->created_at}}</time-ago>
                    @endif
                @else
                    <time-ago>{{$post->postponed_to}}</time-ago>
                @endif
                {{-- <div class="post-socialize">
                    <div class="sharethis-inline-share-buttons"></div>
                </div> --}}
            </div>
            <div class="post-body">
                {!! $post->content !!} {{--$post->titles->count()--}}
                <p class="title-tags">
                    <span><i class="fas fa-hashtag orange"></i></span>
                    @forelse($post->tags as $t)
                        <a href="/tags/{{ $t->slug }}" rel="tag">{{ $t->name }}</a>
                    @empty
                        <span class="no-tags">Sin tags Asociados</span>
                    @endforelse
                </p>
            </div>
            <div>
                {{-- $helper->getVideoLink($post->content)['fullsize'] --}}
            </div>
            <div class="post-vote {{ $votes }}">
                <span class="post-vote-text"><span id="quantity">{{rand(80, 150)}}</span> usuarios indicaron que les gusta este articulo ¿Tu, que opinas?</span>
                &nbsp;&nbsp;
                <a id="up-vote" data-post="{{$post->id}}" data-user="{{\Auth::user() ? \Auth::user()->id : ''}}" data-status="like" href="#up-vote" class="vote"><i class="fas fa-thumbs-up animated"></i></a>
                &nbsp;&nbsp;
                <a id="down-vote" data-post="{{$post->id}}" data-user="{{\Auth::user() ? \Auth::user()->id : ''}}" data-status="dislike" href="#down-vote" class="vote"><i class="fas fa-thumbs-down"></i></a>
            </div>
            <div class="post-author-related no-padding">
                <div class="post-author-image col-md-3 col-sm-3 col-xs-12S">
                    @if(!empty($post->users->image))
                        <img src="{{ $post->users->image }}" alt="{{ $post->users->name }}" class="img-responsive img-circle img-thumbnail" />
                    @else
                        @if($post->users->genre == 0)
                            <img src="/images/girl-avatar.svg" alt="{{ $post->users->name }}" class="img-responsive img-circle img-thumbnail" />
                        @else
                            <img src="/images/man-avatar.svg" alt="{{ $post->users->name }}" class="img-responsive img-circle img-thumbnail" />
                        @endif
                    @endif
                </div>
                <div class="post-author-info col-md-9 col-sm-9 col-xs-12 no-padding">
                    <h3 class="post-author-name"><a href="{{ route('profile',$post->users->slug) }}">{{ $post->users->name }}</a></h3>
                    <div class="post-author-bio col-md-12 col-sm-12 col-xs-12">
                        <span>{!! $post->users->bio !!}</span>
                    </div>
                    <div class="post-author-social-links col-md-12 col-sm-12 col-xs-12">
                        @if(!empty($post->users->twitter))
                            <a href="https://twitter.com/{{ $post->users->twitter }}" title="{{ $post->users->name }} en Twitter"><i class="fab fa-twitter fa-lg"></i></a>
                        @endif
                        @if(!empty($post->users->facebook))
                            <a href="https://facebook.com/{{ $post->users->facebook }}" title="{{ $post->users->name }} en Facebook"><i class="fab fa-facebook fa-lg"></i></a>
                        @endif
                        @if(!empty($post->users->googleplus))
                            <a href="https://plus.google.com/+{{ $post->users->googleplus }}" title="{{ $post->users->name }} en Google+"><i class="fab fa-google-plus-g fa-lg"></i></a>
                        @endif
                        @if(!empty($post->users->behance))
                            <a href="https://www.behance.net/{{ $post->users->behance }}" title="{{ $post->users->name }} en Behance"><i class="fab fa-behance fa-lg"></i></a>
                        @endif
                        @if(!empty($post->users->pinterest))
                            <a href="http://pinterest.com/{{ $post->users->pinterest }}" title="{{ $post->users->name }} en Pinterest"><i class="fab fa-pinterest-p fa-lg"></i></a>
                        @endif
                        @if(!empty($post->users->deviantart))
                        <a href="http://{{ $post->users->deviantart }}.deviantart.com/" title="{{ $post->users->name }} en DeviantArt"><i class="fab fa-deviantart fa-lg"></i></a>
                        @endif
                        @if(!empty($post->users->tumblr))
                            <a href="http://tumblr.com/{{ $post->users->tumblr }}" title="{{ $post->users->name }} en Tumblr"><i class="fab fa-tumblr fa-lg"></i></a>
                        @endif
                        @if(!empty($post->users->instagram))
                            <a href="http://instagram.com/{{ $post->users->instagram }}" title="{{ $post->users->name }} en Instagram"><i class="fab fa-instagram fa-lg"></i></a>
                        @endif
                        @if(!empty($post->users->website))
                            <a href="http://{{ $post->users->website }}/" title="Sitio web de {{ $post->users->name }}"><i class="fab fa-external-link-alt fa-lg"></i></a>
                        @endif
                    </div>
                </div>
                <div class="clearfix"></div>
            </div>
            @if ($post->titles->count() > 0)
                @foreach ($post->titles as $title)
                    <div class="title-related row">
                        <div class="col-xs-12 col-sm-2 col-md-2">
                            <img class="related-image img-responsive" @if($title->images == null) src="/images/no_image.jpg" @else src="{{ $title->images->thumbnail }}" @endif alt="" />
                        </div>
                        <div class="related-details col-xs-12 col-sm-10 col-md-10">
                            <div class="related-name">
                                <a href="{{ route('titles') }}/{{ $title->type->slug }}/{{ $title->slug }}">
                                    <h4>{{ $title->name }}</h4>
                                </a>
                            </div>
                            <div class="related-type"><small>{{ $title->type->name }}</small></div>
                            <div class="related-sinopsis">
                                {!! str_limit($title->sinopsis, 450) !!}
                                <p class="pull-right"><a class="btn-link orange" href="{{ route('titles') }}/{{ $title->type->slug }}/{{ $title->slug }}">Leer Mas</a></p>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                @endforeach
            @endif
            <div class="post-footer col-md-12">
                {{-- <div class="row options-toolbar col-md-12 text-left">
                    <a href="" onclick="history.back()" class="btn btn-warning"><i class="fas fa-chevron-left"></i> Volver</a>
                </div> --}}
                @if(count($relateds) > 0)
                    <div class="post-relateds col-md-12 row">
                        <h3>Relacionados al Titulo</h3>
                        @forelse($relateds as $related)
                        <div class="col-md-4 col-sm-6 col-xs-12">
                            <div class="related-card">
                                <div class="related-header">
                                    <div class="related-image">
                                        <img src="{{str_replace('1920','480', $related->image)}}" alt="">
                                    </div>
                                    <div class="related-info col-md-12">
                                        <div class="related-title">
                                            <h3><a href="/posts/{{ $related->slug }}">{{ $related->title }}</a></h3>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @empty
                        <div class="grid-item">
                            <p>No hay mas articulos Relacionados a este titulo</p>
                        </div>
                        @endforelse
                    </div>
                @endif
                <div class="post-relateds col-md-12 row">
                    <h3>Puede que te interese</h3>
                    @foreach($otherArticles as $article)
                        <div class="col-md-4 col-sm-6 col-xs-12">
                            <div class="related-card">
                                <div class="related-header">
                                    <div class="related-image">
                                        <img src="{{str_replace('1920','480', $article->image)}}" alt="">
                                    </div>
                                    <div class="related-info col-md-12">
                                        <div class="related-title">
                                            <h3><a href="/posts/{{ $article->slug }}">{{ $article->title }}</a></h3>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="post-comments">
                <div id='vuukle-emote'></div>
                {{-- <div id="fb-root"></div>
                <script async defer src="https://connect.facebook.net/es_LA/sdk.js#xfbml=1&version=v3.2&appId=439547086253998&autoLogAppEvents=1"></script>
                <div class="fb-comments" data-href="https://coanime.net/posts/{{$post->slug}}" data-width="100%" data-numposts="10"></div> --}}
                <script>
                    var VUUKLE_CONFIG = {
                        apiKey: "eb185a7d-b521-441f-a6dd-b74a797be9ad",
                        articleId: {{$post->id}},
                    };
                    // ⛔️ DON'T EDIT BELOW THIS LINE
                    (function() {
                        var d = document,
                            s = d.createElement('script');
                    s.src = 'https://cdn.vuukle.com/platform.js';
                    (d.head || d.body).appendChild(s);
                    })();
                </script>
                {{-- <div class="disqus-comments">
                    <div id="disqus_thread"></div>
                    <script>
						(function() {
							var d = document, s = d.createElement('script');
							s.src = 'https://coanimenet.disqus.com/embed.js';
							s.setAttribute('data-timestamp', +new Date());
							(d.head || d.body).appendChild(s);
						})();
                    </script>
                </div> --}}


            </div>
        </div>
    </div>
</div>
@endsection
