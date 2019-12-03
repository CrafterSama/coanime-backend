import Vue from 'vue'
import ExampleComponent from './ExampleComponent'
import TimeAgo from './TimeAgo'

[
  ExampleComponent,
  TimeAgo,
].forEach(c => {
  Vue.component(c.name, c)
})
