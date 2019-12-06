import Vue from 'vue'
import ExampleComponent from './ExampleComponent'
import TimeAgo from './TimeAgo'
import AnimeToday from './AnimeToday'

[
  ExampleComponent,
  TimeAgo,
  AnimeToday,
].forEach(c => {
  Vue.component(c.name, c)
})
