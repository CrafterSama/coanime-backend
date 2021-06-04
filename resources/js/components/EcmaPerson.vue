
<template>
  <div class="content-wrapper">
    <loading-articles v-if="loading" />
    <div v-else id="title">
      <div class="title-header">
        <figure class="title-header-image">
          <img v-if="person.image !== null" :src="routes('people-image',person.image)" :alt="`${person.name} (${person.japanese_name})`">
          <img v-else src="/assets/images/no_post_image.jpg" :alt="`${person.name} (${person.japanese_name})`">
        </figure>
        <div class="overlayer" />
        <div class="boxed-header-info">
          <div class="boxed-container">
            <div class="title-name-box">
              <div class="before-title-box" />
              <h1 class="title-name">
                {{ person.name }} <span class="text-italic">{{ `(${person.japanese_name})` }}</span>
                <img v-if="person.falldown === 'si'" class="stone-icon" src="/assets/images/stone-icon.svg">
              </h1>
            </div>
          </div>
        </div>
      </div>
      <div class="title-content">
        <div class="title-info container">
          <div class="title-top-box overlap-banner">
            <figure class="title-image overlap-banner">
              <img v-if="person.image !== null" :src="routes('people-image', person.image)" :alt="`${person.name} (${person.japanese_name})`">
              <img v-else src="/assets/images/no_image.jpg" :alt="`${person.name} (${person.japanese_name})`">
            </figure>
            <div class="title-info-box">
              <ul class="title-info-details overlap-banner">
                <li>
                  <i class="fas fa-language" /> <span><span class="text-strong">Nombre de Nacimiento:</span> <span class="text-italic">{{ person.japanese_name }}</span></span>
                </li>
                <li>
                  <i class="fas fa-city" />
                  <span>
                    <span class="text-strong">Ciudda y Pais de Origen:</span>
                    {{ person.city !== null ? `${person.city.name}, ` : 'Sin datos acerca de la Ciudad y el distrito de origen, ' }} {{ person.country !== null ? `${person.country.name}` : '' }}
                  </span>
                </li>
                <li>
                  <i class="fas fa-calendar" />
                  <span>
                    <span class="text-strong">Fecha de Nacimiento:</span>
                    <vue-moment :timestamp="person.birthday" :format="'LL'" />
                  </span>
                </li>
                <li v-if="person.falldown_date !== null">
                  <i class="fas fa-calendar" />
                  <span>
                    <span class="text-strong">Fercha de Desceso:</span>
                    <vue-moment :timestamp="person.falldown_date" :format="'LL'" />
                  </span>
                </li>
                <li>
                  <i class="fas fa-tags" />
                  <span>
                    <span class="text-strong">Areas / Habilidades / Hobbies:</span>
                    {{ person.areas_skills_hobbies }}
                  </span>
                </li>
              </ul>
            </div>
          </div>
          <div class="title-sinopsis"
               v-html="person.bio"
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
  name: 'EcmaPerson',
  components: {
    [TimeAgo.name]: TimeAgo,
    [VueMoment.name]: VueMoment,
    [LoadingArticles.name]: LoadingArticles
  },
  mixins: [routes],
  props: ['slug'],
  data: function () {
    return {
      person: 'Without Info',
      loading: false
    }
  },
  created() {
    this.getPerson()
  },
  methods: {
    postImage(str) {
      return str.replace('1920', '480')
    },
    getPerson() {
      this.loading = true
      fetch(`/api/v1/people/${this.slug}`)
        .then(res => res.json())
        .then(response => {
          this.person = response.person
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
