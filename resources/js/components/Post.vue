<template>
  <div class="content-wrapper">
    <loading-articles v-if="loading && article === 'No Info'" />
    <div v-else class="article-container">
      <div class="article-main-header">
        <parallax
          :speed-factor="0.3"
          :direction="'down'"
          :section-height="100"
          :breakpoint="'(min-width: 992px)'"
          :section-class="'ParallaxHero'"
        >
          <img :src="article.image" :alt="article.title">
        </parallax>
        <div class="full-header-title-bg">
          <div class="article__info-top">
            <div v-if="article.categories" class="info__article-category">
              {{ article.categories.name }}
            </div>
            <h1 class="info__article-title">
              {{ article.title }}
            </h1>
            <h2 class="info__article-subtitle">
              {{ article.excerpt }}
            </h2>
            <p>
              <time-ago>{{ article.postponed_to }}</time-ago>por
              <a v-if="article.users"
                 class="user-author"
                 :href="routes('user', article.users.slug)"
              >{{ article.users.name }}</a>
            </p>
          </div>
        </div>
      </div>
      <div class="article__info-box">
        <div class="container-lg">
          <div class="article">
            <div class="article-wrapper">
              <main
                class="info__article-content"
                v-html="article.content"
              />
            </div>
            <div
              :class="{
                article__side: windowWidth > 992,
                'article__side hide': windowWidth < 992
              }"
            >
              {{/* Related Title */}}
              <div class="article-relatedTitles">
                <div id="relatedTitle" class>
                  <div class="relatedTitle">
                    <div
                      v-for="title in article.titles"
                      :key="title.id"
                      class="info__relatedTitle"
                    >
                      <div class="info__relatedTitle-image">
                        <img
                          :src="
                            getTitleImage(
                              String(
                                title.images.name
                              )
                            )
                          "
                          :alt="title.name"
                        >
                      </div>
                      <div class="info__related">
                        <p
                          class="info__relatedTitle-category"
                        >
                          {{ title.type.name }}
                        </p>
                        <a
                          :href="
                            routes(
                              'title',
                              title.slug,
                              title.type.slug
                            )
                          "
                        >
                          <h3
                            class="info__relatedTitle-title"
                          >
                            {{ title.name }}
                          </h3>
                        </a>
                        <ul class="info__relatedTitle-rate">
                          <li class="selected">
                            <i class="fas fa-star" />
                          </li>
                          <li class="selected">
                            <i class="fas fa-star" />
                          </li>
                          <li class="selected">
                            <i class="fas fa-star" />
                          </li>
                          <li>
                            <i class="fas fa-star" />
                          </li>
                          <li>
                            <i class="fas fa-star" />
                          </li>
                        </ul>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              {{/** Articles Relateds by the Serie Title */}}
              <div class="article-relateds">
                <div id="relateds" class>
                  <div class="relateds">
                    <div
                      v-for="feature in features"
                      :key="feature.id"
                      class="info__relateds"
                    >
                      <a :href="routes('posts', feature.slug)">
                        <div class="info__relateds-image">
                          <img
                            :src="
                              getPostImageThumb(
                                String(
                                  feature.image
                                )
                              )
                            "
                            :alt="feature.title"
                          >
                        </div>
                        <h3 class="info__relateds-title">
                          {{ feature.title }}
                        </h3>
                      </a>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div id="tags" class>
              <div class="tags">
                <ul class="info__article-tags">
                  <i class="fas fa-hashtag" />
                  <li v-for="tag in article.tags" :key="tag.id">
                    <a
                      :href="routes('tag', tag.slug)"
                      class="tag"
                    >{{ tag.name }}</a>
                  </li>
                </ul>
              </div>
            </div>
          </div>
          <div v-if="article.users" id="author" class>
            <div class="author">
              <div class="info__article-author">
                <img
                  :src="article.users.image"
                  :alt="article.users.nick"
                >
                <div class="info__author">
                  <p class="info__author-name">
                    <a
                      :href="routes('user', article.users.slug)"
                    >{{ article.users.name }}</a>
                  </p>
                  <p class="info__author-ocupation">
                    <span v-html="article.users.bio" />
                  </p>
                </div>
              </div>
            </div>
          </div>
          <div
            :class="{
              'article__side-small hide': windowWidth > 992,
              'article__side-small': windowWidth < 992
            }"
          >
            {{/* Related Title */}}
            <div class="article-relatedTitles">
              <div id="relatedTitle" class>
                <div class="relatedTitle">
                  <div
                    v-for="title in article.titles"
                    :key="title.id"
                    class="info__relatedTitle"
                  >
                    <div class="info__relatedTitle-image">
                      <img
                        :src="
                          getTitleImage(
                            String(title.images.name)
                          )
                        "
                        :alt="title.name"
                      >
                    </div>
                    <div class="info__related">
                      <p class="info__relatedTitle-category">
                        {{ title.type.name }}
                      </p>
                      <a
                        :href="
                          routes(
                            'title',
                            title.slug,
                            title.type.slug
                          )
                        "
                      >
                        <h3
                          class="info__relatedTitle-title"
                        >
                          {{ title.name }}
                        </h3>
                      </a>
                      <ul class="info__relatedTitle-rate">
                        <li class="selected">
                          <i class="fas fa-star" />
                        </li>
                        <li class="selected">
                          <i class="fas fa-star" />
                        </li>
                        <li class="selected">
                          <i class="fas fa-star" />
                        </li>
                        <li>
                          <i class="fas fa-star" />
                        </li>
                        <li>
                          <i class="fas fa-star" />
                        </li>
                      </ul>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            {{/** Articles Relateds by the Serie Title */}}
            <div class="article-relateds">
              <div id="relateds" class>
                <div class="relateds">
                  <div
                    v-for="feature in features"
                    :key="feature.id"
                    class="info__relateds"
                  >
                    <a :href="routes('posts', feature.slug)">
                      <div class="info__relateds-image">
                        <img
                          :src="
                            getPostImageThumb(
                              String(feature.image)
                            )
                          "
                          :alt="feature.title"
                        >
                      </div>
                      <h3 class="info__relateds-title">
                        {{ feature.title }}
                      </h3>
                    </a>
                  </div>
                </div>
              </div>
            </div>
          </div>
          {{/* Articles related to the Category */}}
          <div id="features" class>
            <div class="features">
              <h2>
                Otras noticias relacionadas a
                {{ article.categories.name }}
              </h2>
              <div class="info__features">
                <div
                  v-for="related in relateds"
                  :key="related.id"
                  class="info__features-box"
                >
                  <div class="info__features-image">
                    <a :href="routes('posts', related.slug)">
                      <img
                        :src="
                          getPostImageThumb(
                            String(related.image)
                          )
                        "
                        :alt="related.title"
                      >
                    </a>
                  </div>
                  <p class="info__features-category">
                    <a :href="routes('category', related.categories.slug)">{{ related.categories.name }}</a>
                  </p>
                  <h3 class="info__features-title">
                    <a :href="routes('posts', related.slug)">
                      {{ related.title }}
                    </a>
                  </h3>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div id="subscribe">
        <div class="subscribe">
          <h1>Boletin</h1>
          <div class="subscribe__form">
            <mailchimp-subscribe
              url="https://coanime.us2.list-manage.com/subscribe/post"
              user-id="c7f6b94a11f43f6650745bb08"
              list-id="cf8ab120c9"
              @error="onError"
              @success="onSuccess"
            >
              <template
                v-slot="{
                  subscribe,
                  setEmail,
                  error,
                  success,
                  loading
                }"
              >
                <form @submit.prevent="subscribe">
                  <input
                    placeholder="Tu Email"
                    name="EMAIL"
                    type="email"
                    @input="setEmail($event.target.value)"
                  >
                  <button type="submit">
                    Suscribirse
                  </button>
                  <div v-if="error">
                    {{ error }}
                  </div>
                  <div v-if="success">
                    Gracias por Suscribirte!
                  </div>
                  <div v-if="loading">
                    Enviando…
                  </div>
                </form>
              </template>
            </mailchimp-subscribe>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import MailchimpSubscribe from 'vue-mailchimp-subscribe'
import LoadingArticles from './Common/Loading/LoadingArticles'
import Parallax from 'vue-parallaxy'
import { ResponsiveDirective } from 'vue-responsive-components'
import { routes } from '../mixins'
import TimeAgo from './TimeAgo'

export default {
  name: 'Post',
  components: {
    [TimeAgo.name]: TimeAgo,
    [LoadingArticles.name]: LoadingArticles,
    Parallax,
    MailchimpSubscribe
  },
  directives: {
    responsive: ResponsiveDirective
  },
  mixins: [routes],
  props: ['postSlug'],
  data: function () {
    return {
      article: 'No Info',
      features: 'No Info',
      relateds: 'No Info',
      boxes: false,
      loading: false,
      windowWidth: window.innerWidth
    }
  },
  created() {
    this.getPostInfo()
  },
  mounted() {
    window.onresize = () => {
      this.windowWidth = window.innerWidth
    }
  },
  methods: {
    getTitleImage(str) {
      return str
    },
    getPostImageThumb(str) {
      return str.replace('1920', '480')
    },
    getPostInfo() {
      this.loading = true
      fetch(`/api/v1/article/${this.postSlug}`)
        .then(res => res.json())
        .then(response => {
          this.article = response.result
          this.features = response.relateds
          this.relateds = response.other_articles
          this.loading = false
        })
        .catch(error => console.log(error))
    },
    onError() {

    },
    onSuccess() {

    }
  }
}
</script>
