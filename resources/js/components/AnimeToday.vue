<template>
  <div class="boxed-container">
    <div v-if="loading">
      <div class="loading">
        <div class="fa-3x">
          <i class="fas fa-circle-notch fa-spin" />
        </div>
      </div>
    </div>
    <div v-else class="series-grid">
      <h3 class="section-title">
        <i class="fab fa-chromecast" />
        Series en emisión hoy
      </h3>
      <div class="broadcastTitles">
        <div v-if="titles && titles.length">
          <vue-glide :per-view="5" :gap="5" :bound="true" :swipe-threshold="200" :breakpoints="breakpoints">
            <vue-glide-slide v-for="title in titles" :key="title.mal_id" :style="{width: '200px'}">
              <div class="box">
                <figure class="item__title-box-image">
                  <a class="title-link" :href="url(title.type, title.title)">
                    <img class="item__title-image" :src="title.image_url" :alt="title.title">
                  </a>
                </figure>
                <div class="item__title-info">
                  <h2 class="info__title-name">
                    <a class="title-link" :href="url(title.type, title.title)">{{ title.title }}</a>
                  </h2>
                </div>
              </div>
            </vue-glide-slide>
            <template slot="control">
              <button data-glide-dir="<">
                <i class="fas fa-chevron-left" />
              </button>
              <button data-glide-dir=">">
                <i class="fas fa-chevron-right" />
              </button>
            </template>
          </vue-glide>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import { Glide, GlideSlide } from 'vue-glide-js'

export default {
  name: 'AnimeToday',
  components: {
    [Glide.name]: Glide,
    [GlideSlide.name]: GlideSlide
  },
  data: function () {
    return {
      titles: 'not updated',
      loading: false,
      breakpoints: {
        768: {
          perView: 3
        },
        480: {
          perView: 2
        }
      }
    }
  },
  created() {
    this.getTodaySchedule()
  },
  methods: {
    getDay() {
      let days = [
        'sunday',
        'monday',
        'tuesday',
        'wednesday',
        'thursday',
        'friday',
        'saturday'
      ]
      // eslint-disable-next-line
      let options = {
        formatMatcher: 'best fit',
        weekday: 'long', //, year: 'numeric', month: 'long', day: 'numeric', hour: '2-digit', minute: '2-digit', second: '2-digit'
        hour12: false
      }
      let currentDate = new Date() // .toLocaleTimeString('en-us', options)
      let weekdayValue = currentDate.getDay()
      let today = days[weekdayValue]

      return today
    },
    strToSlug(str) {
      str = str.replace(/^\s+|\s+$/g, '') // trim
      str = str.toLowerCase()

      // remove accents, swap ñ for n, etc
      var from = 'åàáãäâèéëêìíïîòóöôùúüûñç·_,:;/'
      var to = 'aaaaaaeeeeiiiioooouuuunc-----'

      for (var i = 0, l = from.length; i < l; i++) {
        str = str.replace(new RegExp(from.charAt(i), 'g'), to.charAt(i))
      }

      str = str
        .replace(/[^a-z0-9 -]/g, '') // remove invalid chars
        .replace(/\s+/g, '-') // collapse whitespace and replace by -
        .replace(/-+/g, '-') // collapse dashes

      return str
    },
    url(type, title) {
      return (
        '/ecma/titulos/' +
        this.strToSlug(String(type)) +
        '/' +
        this.strToSlug(String(title))
      )
    },
    getTodaySchedule() {
      this.loading = true
      fetch(`https://api.jikan.moe/v3/schedule/${this.getDay()}`)
        .then(res => res.json())
        .then(response => {
          this.titles = response[this.getDay()]
          this.loading = false
        })
        .catch(error => error)
    }
  }
}
</script>
