<template>
  <div class="d-flex flex-column justify-content-center">
    <div class="d-flex flex-column justify-content-center">
      <star-rating
        v-model="rating"
        inactive-color="#cacaca"
        active-color="#ff8800"
        :star-size="18"
        :show-rating="false"
        :round-start-rating="false"
        :read-only="true"
        :fixed-points="2"
        :rounded-corners="true"
        :border-width="3"
        border-color="#ff8800"
      />
    </div>
    <span>{{ rating }} / 5</span>
  </div>
</template>
<script>
import StarRating from 'vue-star-rating'

export default {
  name: 'TitleStarRating',
  components: {
    StarRating
  },
  props: ['titleName'],
  data: function () {
    return {
      rating: 0
    }
  },
  created() {
    this.getPostTitleInfo()
  },
  methods: {
    getPostTitleInfo() {
      if (this.$props.titleName) {
        fetch(`https://api.jikan.moe/v3/search/anime?q=${this.$props.titleName}`)
          .then(res => res.json())
          .then(response => {
            this.rating = Number((response.results[0].score / 2).toFixed(2))
          })
          .catch(error => console.log(error))
      }
    }
  }
}
</script>

<style>
.vue-star-rating {
    display: flex;
    align-items: center;
    justify-content: center;
}
</style>
