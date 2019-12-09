import Vue from 'vue'
import TimeAgo from './TimeAgo'
import AnimeToday from './AnimeToday'
import AllPosts from './AllPosts'

[
  TimeAgo,
  AnimeToday,
  AllPosts,
].forEach(c => {
  Vue.component(c.name, c)
})
