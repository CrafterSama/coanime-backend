import Vue from 'vue'
import AllPosts from './AllPosts'
import AnimeToday from './AnimeToday'
import EcmaMagazine from './EcmaMagazine'
import EcmaMagazines from './EcmaMagazines'
import EcmaPeople from './EcmaPeople'
import EcmaPerson from './EcmaPerson'
import EcmaTitle from './EcmaTitle'
import EcmaTitles from './EcmaTitles'
import Error404 from './Error404'
import Particles from './Particles'
import Post from './Post'
import TimeAgo from './TimeAgo'
import VueMoment from './VueMoment'

[
  AnimeToday,
  AllPosts,
  EcmaMagazine,
  EcmaMagazines,
  EcmaPeople,
  EcmaPerson,
  EcmaTitle,
  EcmaTitles,
  Error404,
  Post,
  Particles,
  TimeAgo,
  VueMoment
].forEach(c => {
  Vue.component(c.name, c)
})
