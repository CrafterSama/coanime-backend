import Vue from 'vue'
import AllPosts from './AllPosts'
import AnimeToday from './AnimeToday'
import Error404 from './Error404'
import TimeAgo from './TimeAgo'

[
    TimeAgo,
    AnimeToday,
    AllPosts,
    Error404
].forEach(c => {
    Vue.component(c.name, c)
})
