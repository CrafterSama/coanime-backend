
<template>
  <div class="content-wrapper">
    <loading-articles v-if="loading" />
    <div v-else id="title">
      <div class="title-header">
        <figure class="title-header-image">
          <img v-if="!randomImage && title.images" :src="title.images.name" :alt="title.name">
          <img v-if="!randomImage && !title.images" src="/assets/images/no_post_image.jpg" :alt="title.name">
          <img v-else :src="randomImage" :alt="title.name">
        </figure>
        <div class="overlayer" />
      </div>
      <div class="title-content">
        <div class="title-info container">
          <div class="title-top-box overlap-banner">
            <figure class="title-image overlap-banner">
              <img v-if="title.images" :src="title.images.name" :alt="title.name">
              <img v-else src="/assets/images/no_image.jpg" :alt="title.name">
            </figure>
            <div class="title-info-box">
              <div class="title-name-box">
                <h1 class="title-name">
                  {{ title.name }}
                </h1>
              </div>
              <ul class="title-info-details overlap-banner">
                <li>
                  <span class="text-strong">Tipo:</span>
                  <span class="info-details-type">
                    <a :href="routes('type', title.type.slug)">{{ title.type.name }}</a>
                  </span>
                </li>
                <li>
                  <span class="text-strong">Otros Títulos:</span><span>{{ title.other_titles }}</span>
                </li>
                <li>
                  <span v-if="title.type.name !== 'Juegos'" class="text-strong">Desde:</span>
                  <span v-else class="text-strong">Salida:</span>
                  <vue-moment :timestamp="title.broad_time" :format="'LL'" />
                </li>
                <li v-if="title.type.name !== 'Juegos'">
                  <span class="text-strong">Hasta:</span>
                  <span v-if="title.broad_finish === null">Sin Información precisa</span>
                  <vue-moment v-else :timestamp="title.broad_finish" :format="'LL'" />
                </li>
                <li>
                  <span class="text-strong">Generos:</span>
                  <span v-for="genre in title.genres" :key="genre.id" class="genre-tag">
                    <a :href="routes('genre', genre.slug)">{{ genre.name }}</a>
                  </span>
                </li>
                <li v-if="title.type.name !== 'Juegos'">
                  <span class="text-strong">Episodios:</span>
                  <span v-if="title.episodies === '' || title.episodies === '0'">Sin Información precisa</span>
                  <span v-else>{{ title.episodies }}</span>
                </li>
                <li>
                  <span class="text-strong">Clasificación:</span><span>{{ title.rating.name }} ({{ title.rating.description }})</span>
                </li>
                <li>
                  <span class="text-strong">Estatus:</span><span class="title-status">{{ title.status }}</span>
                </li>
              </ul>
            </div>
          </div>
          <div class="title-sinopsis"
               v-html="title.sinopsis"
          />
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import LoadingArticles from './Common/Loading/LoadingArticles'
import TimeAgo from './TimeAgo'
import VueMoment from './VueMoment'
import { routes } from '../mixins'

export default {
  name: 'EcmaTitle',
  components: {
    [TimeAgo.name]: TimeAgo,
    [VueMoment.name]: VueMoment,
    [LoadingArticles.name]: LoadingArticles
  },
  mixins: [routes],
  props: {
    type: {
      type: String,
      required: true
    },
    slug: {
      type: String,
      required: true
    }
  },
  data: function () {
    return {
      title: 'Without Info',
      randomImage: 'Without Info',
      posts: 'Without Info',
      boxes: false,
      loading: false
    }
  },
  async mounted() {
    await this.getData()
  },
  methods: {
    postImage(str) {
      return str.replace('1920', '480')
    },
    async getData() {
      this.loading = true
      try {
        // Title
        const responseTitle = await fetch(
          `/api/v1/titles/${this.type}/${this.slug}`
        )
        const jsonTitle = await responseTitle.json()

        // Image
        const responseImage = await fetch(
          `/api/v1/random-image-title/${this.slug}`
        )
        const jsonImage = await responseImage.json()

        // Posts
        const responsePosts = await fetch(
          `/api/v1/titles/${this.type}/${this.slug}/posts`
        )
        const jsonPosts = await responsePosts.json()

        // Data assign
        this.posts = jsonPosts
        this.title = jsonTitle.data
        if (jsonImage.message === 'OK') {
          this.randomImage = jsonImage.image
        } else {
          this.randomImage = false
        }
      } catch (error) {
        console.log(error)
      } finally {
        this.loading = false
      }
    },
    changeGrid() {
      this.boxes = !this.boxes
    }
  }
}
</script>
