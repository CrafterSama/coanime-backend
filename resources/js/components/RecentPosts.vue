<template>
  <div class="recent-box">
    <div id="recentPost" class="container-lg">
      <h3 class="section-title">
        <i class="fas fa-rss orange-text" /> <span>Lo más reciente</span>
      </h3>
      <div v-for="new in news" :key="new.id" class="recentPost">
        <div class="inbox">
          <div class="box__item">
            <figure class="item__image">
              <a :href="routes('posts', new.slug)" :alt="">
                <img
                  class="animate-image"
                  :srcSet="getSrcSetString(new.image)"
                  :src="new.image ? new.image.replace('1920', '800') : ''"
                  :alt="new.title"
                >
              </a>
            </figure>
            <div class="overlayer" />
            <div class="item__info text-shadow bottom-attach">
              <div class="info__news-category">
                <a :href="routes('categorias', new.categories.slug)">{{ new.categories.name }}</a>
              </div>
              <h2 class="info__news-title">
                <a :href="routes('posts', new.slug)">{{ $new.title }}</a>
              </h2>
              <h4 class="info__news-sub-title">
                {{ $new.excerpt }}
              </h4>
              <p>
                <i class="fas fa-user" /> <span class="info__person">{{ $new.users.name }}</span>
                <i class="fas fa-clock" /> <time-ago>{{ $new.postponed_to }}</time-ago>
              </p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { timeAgo } from 'vue-timeago'
import { helpers } from '../mixins'

export default {
  mixins: [helpers]
}
</script>
