<template>
  <div class="titles-box">
    <loading-articles v-if="loading" />
    <div v-else>
      <div class="search-box">
        <div class="container">
          <div class="boxed-container">
            <form
              id="serch-form"
              class="search-form"
              autocomplete="off"
              @submit.prevent="search"
            >
              <div class="form-group d-flex justify-content-center">
                <input
                  class="form-control form-control-lg"
                  autocomplete="off"
                  type="text"
                  name="search"
                  placeholder="Busqueda de Personas"
                  @keyup="realTimeSearch"
                  @blur="hide"
                  @focus="show = true"
                >
              </div>
              <div v-if="results.length > 0 && show" class="searching-results">
                <div
                  v-for="(item, index) in results"
                  :key="index"
                  class="result-item"
                >
                  <a :href="routes('people', item.slug)">
                    <div class="result-item-url">
                      <figure class="result-item-image">
                        <img
                          v-if="item.image"
                          :src="routes('people-image', item.image, null, true)"
                          :alt="`${item.name} (${item.japanese_name})`"
                        >
                        <img
                          v-else
                          src="/assets/images/no_image.jpg"
                          :alt="`${item.name} (${item.japanese_name})`"
                        >
                      </figure>
                      <div class="result-item-info">
                        <h4 class="result-item-name">
                          {{ item.name }} ({{ item.japanese_name }})
                        </h4>
                        <p>({{ item.areas_skills_hobbies }})</p>
                      </div>
                    </div>
                  </a>
                </div>
                <button class="submit-search" type="submit">
                  Ver todos los resultados para
                  <span class="enfasis-underline">{{ searching }}</span>
                </button>
              </div>
            </form>
          </div>
        </div>
      </div>

      <div class="all-titles">
        <div v-if="load" class="container">
          <div class="loading">
            <div class="fa-3x">
              <i class="fas fa-circle-notch fa-spin" />
            </div>
          </div>
        </div>
        <div v-else class="container">
          <div class="grid-titles">
            <div
              v-for="(person, index) in people.data"
              :key="index"
              class="title-item"
              @mouseover="hover = index"
              @mouseleave="hover = null"
            >
              <figure class="title-image">
                <img
                  v-if="person.image !== null"
                  :src="routes('people-image', person.image)"
                  :alt="`${person.name} (${person.japanese_name})`"
                >
                <img
                  v-else
                  src="/assets/images/no_image.jpg"
                  :alt="person.name"
                >
                <div
                  :class="{
                    overlayer: hover !== index,
                    'overlayer hover': hover === index
                  }"
                >
                  <a :href="routes('people', person.slug)" />
                </div>
              </figure>
              <div class="title-info">
                <div class="title-type">
                  <p>
                    {{
                      person.country
                        ? `${person.country.emoji} ${person.country.name}`
                        : ''
                    }}
                  </p>
                </div>
                <h3 class="title-name person">
                  <a :href="routes('people', person.slug)">
                    {{ person.name }} <br>
                    ({{ person.japanese_name }})
                  </a>
                </h3>
                <div class="genres-list">
                  <p class="title-type">
                    {{ person.areas_skills_hobbies }}
                  </p>
                </div>
              </div>
              <div class="more-info">
                <a :href="routes('people', person.slug)">
                  <i class="fas fa-search-plus" />
                </a>
              </div>
            </div>
          </div>
          <div class="paginator">
            <div class="pages-info">
              Pagina {{ people.current_page }} de {{ people.last_page }}
              {{ people.last_page > 1 ? 'Paginas' : 'Pagina' }}
            </div>
            <div class="space-between" />
            <div class="pages-links">
              <span
                v-if="people.prev_page_url !== null"
                class="page-prev"
                @click="loadPage(people.prev_page_url)"
              >
                <i class="fas fa-chevron-left" />
              </span>
              <span
                v-if="people.next_page_url !== null"
                class="page-next"
                @click="loadPage(people.next_page_url)"
              >
                <i class="fas fa-chevron-right" />
              </span>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import EcmaNavbar from './Common/Ecma/EcmaNavbar'
import LoadingArticles from './Common/Loading/LoadingArticles'
import _ from 'lodash'
import { helpers } from '../mixins'

export default {
  name: 'EcmaPeople',
  components: {
    [LoadingArticles.name]: LoadingArticles,
    [EcmaNavbar.name]: EcmaNavbar
  },
  mixins: [helpers],
  props: ['section'],
  data: function () {
    return {
      people: 'No Info',
      results: '',
      searching: '',
      show: false,
      hover: null,
      load: false,
      loading: false
    }
  },
  created() {
    this.getPeople()
  },
  methods: {
    hide() {
      setTimeout(() => {
        this.show = false
      }, 1000)
    },
    realTimeSearch(e) {
      if (e.target.value !== '') {
        this.searching = e.target.value
        fetch(`/api/v1/search/people/${e.target.value}`)
          .then(res => res.json())
          .then(response => {
            this.results = _.take(response.people.data, 10)
          })
      }
    },
    search(e) {
      const form = e.target
      this.load = true
      fetch(`/api/v1/search/people/${e.target[0].value}`)
        .then(res => res.json())
        .then(response => {
          this.results = ''
          this.people = response.people
          this.load = false
          form.reset()
        })
    },
    loadPage(url) {
      this.load = true
      fetch(`${url}`)
        .then(res => res.json())
        .then(response => {
          this.people = response.people
          this.load = false
        })
    },
    getPeople() {
      this.loading = true
      fetch(`/api/v1/people`)
        .then(res => res.json())
        .then(response => {
          this.people = response.people
          this.loading = false
        })
    }
  }
}
</script>
