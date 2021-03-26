<template>
  <div class="titles-box">
    <loading-articles v-if="loading" />
    <div v-else>
      <div class="search-box">
        <div class="container">
          <div class="boxed-container">
            <form id="serch-form" class="search-form" autocomplete="off" @submit.prevent="search">
              <div class="form-group d-flex justify-content-center">
                <input class="form-control form-control-lg" autocomplete="off" type="text" name="search" placeholder="Busqueda de Titulos" @keyup="realTimeSearch" @blur="hide" @focus="show = true">
              </div>
              <div v-if="results.length > 0 && show" class="searching-results">
                <div v-for="(item, index) in results" :key="index" class="result-item">
                  <a :href="routes('title', item.slug, item.type.slug)">
                    <div class="result-item-url">
                      <figure class="result-item-image">
                        <img v-if="item.images" :src="item.images.name" :alt="item.name">
                        <img v-else src="/assets/images/no_image.jpg" :alt="item.name">
                      </figure>
                      <div class="result-item-info">
                        <h4 class="result-item-name">
                          {{ item.name }}
                        </h4>
                        <p>
                          ({{ item.type.name }}, <vue-moment :timestamp="item.broad_time" :format="'YYYY'" />)
                        </p>
                      </div>
                    </div>
                  </a>
                </div>
                <button class="submit-search" type="submit">
                  Ver todos los resultados para <span class="enfasis-underline">{{ searching }}</span>
                </button>
              </div>
            </form>
            <div v-if="section === 'titulos'" class="all-types-links">
              <a :class="{'title-type active': typeSlug === '', 'title-type': typeSlug !== ''}" href="/ecma/titulos">Todos</a>
              <a v-for="type in types" :key="type.id" :class="{'title-type active': type.slug === typeSlug, 'title-type': type.slug !== typeSlug}" :href="routes('type', type.slug)">{{ type.name }}</a>
            </div>
            <div v-if="section === 'generos'" class="all-types-links">
              <a :class="{'title-type active': genreSlug === '', 'title-type': genreSlug !== ''}" href="/ecma/generos">Todos</a>
              <a v-for="genre in themes" :key="genre.id" :class="{'title-type active': genre.slug === genreSlug, 'title-type': genre.slug !== genreSlug}" :href="routes('genre', genre.slug)">{{ genre.name }}</a>
            </div>
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
            <div v-for="(title, index) in titles.data" :key="index" class="title-item" @mouseover="hover = index" @mouseleave="hover = null">
              <figure class="title-image">
                <img v-if="title.images" :src="title.images.name" :alt="title.name">
                <img v-else src="/assets/images/no_image.jpg" :alt="title.name">
                <div :class="{'overlayer': hover !== index, 'overlayer hover': hover === index}">
                  <a :href="routes('title', title.slug, title.type.slug)" />
                </div>
              </figure>
              <div class="title-info">
                <div :class="{'title-type': hover !== index, 'title-type hover': hover === index}">
                  <a :href="routes('type', title.type.slug)">
                    {{ title.type.name }}
                  </a>
                </div>
                <h3 :class="{'title-name': hover !== index, 'title-name hover': hover === index}">
                  <a :href="routes('title', title.slug, title.type.slug)">{{ title.name }}</a>
                </h3>
                <div class="genres-list">
                  <a v-for="genre in title.genres" :key="genre.id" class="title-type" :href="routes('type', genre.slug)">{{ genre.name }}</a>
                </div>
              </div>
              <div class="more-info">
                <a :href="routes('title', title.slug, title.type.slug)">
                  <i class="fas fa-search-plus" />
                </a>
              </div>
            </div>
          </div>
          <div class="paginator">
            <div class="pages-info">
              Pagina {{ titles.current_page }} de
              {{ titles.last_page }} {{ titles.last_page > 1 ? 'Paginas' : 'Pagina' }}
            </div>
            <div class="space-between" />
            <div class="pages-links">
              <span v-if="titles.prev_page_url !== null" class="page-prev" @click="loadPage(titles.prev_page_url)">
                <i class="fas fa-chevron-left" />
              </span>
              <span v-if="titles.next_page_url !== null" class="page-next" @click="loadPage(titles.next_page_url)">
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
import VueMoment from './VueMoment'
import _ from 'lodash'
import { routes } from '../mixins'

export default {
  name: 'EcmaTitles',
  components: {
    [LoadingArticles.name]: LoadingArticles,
    [EcmaNavbar.name]: EcmaNavbar,
    [VueMoment.name]: VueMoment
  },
  mixins: [routes],
  props: {
    typeSlug: {
      type: String,
      default: ''
    },
    genreSlug: {
      type: String,
      default: ''
    },
    section: {
      type: String,
      default: ''
    }
  },
  data() {
    return {
      titles: 'No Info',
      types: 'No Info',
      themes: 'No Info',
      results: '',
      searching: '',
      show: false,
      hover: null,
      load: false,
      loading: false
    }
  },
  created() {
    this.getTitles()
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
        fetch(`/api/v1/search/titles/${e.target.value}`)
          .then(res => res.json())
          .then(response => {
            this.results = _.take(response.result.data, 10)
          })
      }
    },
    search(e) {
      const form = e.target
      this.load = true
      fetch(`/api/v1/search/titles/${e.target[0].value}`)
        .then(res => res.json())
        .then(response => {
          this.results = ''
          this.titles = response.result
          this.types = response.types
          this.themes = response.genres
          this.load = false
          form.reset()
        })
    },
    loadPage(url) {
      this.load = true
      fetch(`${url}`)
        .then(res => res.json())
        .then(response => {
          this.titles = response.result
          this.load = false
        })
    },
    getTitles() {
      this.loading = true

      const fetchData = (url) => {
        fetch(`${url}`)
          .then(res => res.json())
          .then(response => {
            this.titles = response.result;
            this.types = response.types;
            this.themes = response.genres;
            this.loading = false;
          });
      };

      if (this.typeSlug === '' && this.genreSlug === '') {
        fetchData(`/api/v1/titles`);
          /* .then(res => res.json())
          .then(response => {
            this.titles = response.result
            this.types = response.types
            this.themes = response.genres
            this.loading = false
          }) */
      }
      if (this.typeSlug !== '' && this.genreSlug === '') {
        fetchData(`/api/v1/titles/${this.typeSlug}`);
          /* .then(res => res.json())
          .then(response => {
            this.titles = response.result
            this.types = response.types
            this.themes = response.genres
            this.loading = false
          }) */
      }
      if (this.typeSlug === '' && this.genreSlug !== '') {
        fetchData(`/api/v1/genres/${this.genreSlug}`);
          /* .then(res => res.json())
          .then(response => {
            this.titles = response.result
            this.types = response.types
            this.themes = response.genres
            this.loading = false
          }) */
      }
    }
  }
}
</script>
