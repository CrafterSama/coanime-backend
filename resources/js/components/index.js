import Vue from 'vue'
import TimeAgo from './TimeAgo'
import AnimeToday from './AnimeToday'
import AllPosts from './AllPosts'
import Error404 from './Error404'

[
  TimeAgo,
  AnimeToday,
  AllPosts,
  Error404,
].forEach(c => {
  Vue.component(c.name, c)
})
