import Vue from 'vue'
import AllPosts from './AllPosts'
import AnimeToday from './AnimeToday'
import Error404 from './Error404'
import TimeAgo from './TimeAgo'
import Particles from './Particles'

[
    TimeAgo,
    AnimeToday,
    AllPosts,
    Error404,
    Particles
].forEach(c => {
    Vue.component(c.name, c)
})
