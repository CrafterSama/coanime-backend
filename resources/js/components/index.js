import Vue from 'vue'
import AllPosts from './AllPosts'
import AnimeToday from './AnimeToday'
import EcmaTitle from './EcmaTitle'
import Error404 from './Error404'
import Particles from './Particles'
import Post from './Post'
import TimeAgo from './TimeAgo'
import VueMoment from './VueMoment'

[
    AnimeToday,
    AllPosts,
    EcmaTitle,
    Error404,
    Post,
    Particles,
    TimeAgo,
    VueMoment
].forEach(c => {
    Vue.component(c.name, c)
})
