<template>
  <div class="recent-box">
    <div id="recentPost" class="container-lg">
        <h3 class="section-title"><i class="fas fa-rss orange-text"></i> Lo más reciente</h3>
        <div class="recentPost">
            @foreach ($news as $new)
                <div class="box">
                    <div class="box__item">
                        <figure class="item__image">
                            <a href="/posts/{{ $new->slug }}">
                                <img
                                    class="animate-image"
                                    srcSet="{{ str_replace('1920', '480', $new->image) }} 480w,
                                    {{ str_replace('1920', '640', $new->image) }} 640w,
                                    {{ str_replace('1920', '800', $new->image) }} 800w,
                                    {{ str_replace('1920', '1200', $new->image) }} 1200w,
                                    {{ str_replace('1920', '1600', $new->image) }} 1600w,
                                    {{ $new->image }} 1920w"
                                    src="{{ $new->image !== null ? str_replace('1920', '800', $new->image) : '' }}"
                                    alt="{{ $new->title }}"
                                />
                            </a>
                        </figure>
                        <div class="overlayer"></div>
                        <div class="item__info text-shadow bottom-attach">
                        <div class="info__news-category"><a href="/categorias/{{ $new->categories->slug }}">{{ $new->categories->name }}</a></div>
                            <h2 class="info__news-title">
                                <a :href="routes(/posts/{{ $new->slug }}">{{ $new->title }}</a>
                            </h2>
                            <h4 class="info__news-sub-title">{{ $new->excerpt }}</h4>
                            <p>
                            <i class="fas fa-user"></i> <span class="info__person">{{-- <a href="/users/profile/{{ $new->users->slug }}"> --}}{{ $new->users->name }}{{-- </a> --}}</span>
                                <i class="fas fa-clock"></i> <time-ago>{{ $new->postponed_to }}</time-ago>
                            </p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>

</template>
