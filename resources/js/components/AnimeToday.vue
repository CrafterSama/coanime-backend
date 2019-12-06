<template>
    <div className="broadcastTitles">
        <vue-glide>
            <vue-glide-slide>
                <div v-for="title in today" :key="title.mal_id">
                    <div className="box" data-id={index} key={index} style={{ width: 200 }}>
                        <figure className="item__title-box-image">
                            <a className="title-link" :href="`/ecma/titulos/${strToSlug(title.type)}/${strToSlug(title.title)}`">
                                <img className="item__title-image" src={title.image_url} alt={title.title} />
                            </a>
                        </figure>
                        <div className="item__title-info">
                            <h2 className="info__title-name">
                                <a className="title-link" :href="`/ecma/titulos/${strToSlug(title.type)}/${strToSlug(title.title)}`">
                                    {{ title.title }}
                                </a>
                            </h2>
                        </div>
                    </div>
                </div>
            </vue-glide-slide>
            <template slot="control">
                <button data-glide-dir="<">prev</button>
                <button data-glide-dir=">">next</button>
            </template>
        </vue-glide>
    </div>
</template>

<script>
import { Glide, GlideSlide } from 'vue-glide-js'

export default {
  name: "anime-today",
  components: {
    [Glide.name]: Glide,
    [GlideSlide.name]: GlideSlide
  },
  data () {
    return {
      today: null
    }
  },
  methods: {
    getDay: () => {
        let days = [
            "sunday",
            "monday",
            "tuesday",
            "wednesday",
            "thursday",
            "friday",
            "saturday"
        ]
        let options = {
            formatMatcher: "best fit",
            weekday:
            "long" /*, year: 'numeric', month: 'long', day: 'numeric', hour: '2-digit', minute: '2-digit', second: '2-digit'*/,
            hour12: false
        }
        let current_date = new Date() /* .toLocaleTimeString('en-us', options) */
        let weekday_value = current_date.getDay()
        let today = days[weekday_value]

        return today
    },
    strToSlug: (str) => {
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
	}
  },
  mounted () {
    fetch(`https://api.jikan.moe/v3/schedule/${this.getDay()}`)
      .then(res => res.json())
      .then(response => {
        this.today = response[this.getDay()];
      });
  }
};
</script>
