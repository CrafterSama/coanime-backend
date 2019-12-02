import Vue from 'vue'
import ExampleComponent from './ExampleComponent'

[
  ExampleComponent,
].forEach(c => {
  Vue.component(c.name, c)
})
