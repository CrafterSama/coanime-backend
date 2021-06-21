<template>
  <div class="content-wrapper">
    <loading-articles v-if="loading" />
    <div v-else id="title">
      <div class="title-header">
        <figure class="title-header-image">
          <img
            v-if="magazine.image.name"
            :src="routes('magazine-image', magazine.image.name, null, true)"
            :alt="`${magazine.name}`"
          >
          <img
            v-else
            src="/assets/images/no_post_image.jpg"
            :alt="`${magazine.name}`"
          >
        </figure>
        <div class="overlayer" />
        <div class="boxed-header-info">
          <div class="boxed-container">
            <div class="title-name-box">
              <div class="before-title-box" />
              <h1 class="title-name">
                {{ magazine.name }}
              </h1>
            </div>
          </div>
        </div>
      </div>
      <div class="title-content">
        <div class="title-info container">
          <div class="title-top-box overlap-banner">
            <figure class="title-image overlap-banner">
              <img
                v-if="magazine.image.name"
                :src="routes('magazine-image', magazine.image.name, null, true)"
                :alt="`${magazine.name}`"
              >
              <img
                v-else
                src="/assets/images/no_image.jpg"
                :alt="`${magazine.name}`"
              >
            </figure>
            <div class="title-info-box">
              <ul class="title-info-details overlap-banner">
                <li class="mb-2">
                  <div class="text-strong first-child">
                    Tipo:
                  </div>
                  <div class="text-italic">
                    {{ magazine.type.name }}
                  </div>
                </li>
                <li class="mb-2">
                  <div class="text-strong first-child">
                    Frecuencia de Salida:
                  </div>
                  <div>
                    {{ magazine.release.name }}
                  </div>
                </li>
                <li class="mb-2">
                  <div class="text-strong first-child">
                    Fecha de Fundación:
                  </div>
                  <div>
                    <vue-moment
                      :timestamp="magazine.foundation_date"
                      :format="'LL'"
                    />
                  </div>
                </li>
                <li class="mb-2">
                  <div class="text-strong first-child">
                    País de Orígen:
                  </div>
                  <div>
                    {{ `${magazine.country.emoji} ${magazine.country.name}` }}
                  </div>
                </li>
                <li class="mb-2">
                  <div class="text-strong first-child">
                    Website:
                  </div>
                  <div>
                    <a :href="magazine.website">{{ magazine.website }}</a>
                  </div>
                </li>
              </ul>
            </div>
          </div>
          <div class="title-sinopsis" v-html="magazine.about" />
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import LoadingArticles from './Common/Loading/LoadingArticles'
import TimeAgo from './TimeAgo'
import VueMoment from './VueMoment'
import { helpers } from '../mixins'

export default {
  name: 'EcmaMagazine',
  components: {
    [TimeAgo.name]: TimeAgo,
    [VueMoment.name]: VueMoment,
    [LoadingArticles.name]: LoadingArticles
  },
  mixins: [helpers],
  props: ['slug'],
  data: function () {
    return {
      magazine: 'Without Info',
      loading: false
    }
  },
  created() {
    this.getMagazine()
  },
  methods: {
    postImage(str) {
      return str.replace('1920', '480')
    },
    getMagazine() {
      this.loading = true
      fetch(`/api/v1/magazine/${this.slug}`)
        .then(res => res.json())
        .then(response => {
          this.magazine = response.magazine
          this.loading = false
        })
        .catch(error => console.log(error))
    },
    changeGrid() {
      this.boxes = !this.boxes
    }
  }
}
</script>
