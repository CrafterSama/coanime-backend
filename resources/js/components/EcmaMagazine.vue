
<template>
  <div class="content-wrapper">
    <loading-articles v-if="loading" />
    <div v-else id="title">
      <div class="title-header">
        <figure class="title-header-image">
          <img v-if="magazine.image.name" :src="routes('magazine-image',magazine.image.name)" :alt="`${magazine.name}`">
          <img v-else src="/assets/images/no_post_image.jpg" :alt="`${magazine.name}`">
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
              <img v-if="magazine.image.name" :src="routes('magazine-image', magazine.image.name)" :alt="`${magazine.name}`">
              <img v-else src="/assets/images/no_image.jpg" :alt="`${magazine.name}`">
            </figure>
            <div class="title-info-box">
              <ul class="title-info-details overlap-banner">
                <li>
                  <i class="fas fa-tags" /> <span><span class="text-strong">Tipo:</span> <span class="text-italic">{{ magazine.type.name }}</span></span>
                </li>
                <li>
                  <i class="fas fa-calendar-alt" />
                  <span>
                    <span class="text-strong">Frecuencia de Salida:</span>
                    {{ magazine.release.name }}
                  </span>
                </li>
                <li>
                  <i class="fas fa-calendar" />
                  <span>
                    <span class="text-strong">Fecha de Fundación:</span>
                    <vue-moment :timestamp="magazine.foundation_date" :format="'LL'" />
                  </span>
                </li>
                <li>
                  <i class="fas fa-globe-asia" />
                  <span>
                    <span class="text-strong">País de Orígen:</span>
                    {{ magazine.country.name }}
                  </span>
                </li>
                <li>
                  <i class="fas fa-link" />
                  <span>
                    <span class="text-strong">Website:</span>
                    <a :href="magazine.website">{{ magazine.website }}</a>
                  </span>
                </li>
              </ul>
            </div>
          </div>
          <div class="title-sinopsis"
               v-html="magazine.about"
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
  name: 'EcmaMagazine',
  components: {
    [TimeAgo.name]: TimeAgo,
    [VueMoment.name]: VueMoment,
    [LoadingArticles.name]: LoadingArticles
  },
  mixins: [routes],
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
