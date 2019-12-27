<template>
    <div class="titles-box">
        <loading-articles v-if="loading" />
        <div v-else>
            <div class="ecma-navigation">
                <div class="container">
                    <ul class="nav nav-tabs">
                        <li class="nav-item">
                            <a class="nav-link active" href="/ecma/titulos">
                                Titulos
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/ecma/personas">Personas</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/ecma/revistas">Revistas</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/ecma/empresas">Empresas</a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="search-box">
                <div class="container">
                    <h3 class="titles-box-title d-flex justify-content-center">
                        Busqueda de Titulos
                    </h3>
                    <div class="boxed-container">
                        <form id="serch-form" class="search-form" @submit.prevent="search">
                            <div class="form-group d-flex justify-content-center">
                                <input
                                    class="form-control form-control-lg"
                                    type="text"
                                    name="search"
                                    placeholder="hero mask..."
                                    @keyup="realTimeSearch"
                                >
                            </div>
                        </form>
                        <div class="all-types-links">
                            <a :class="{ 'title-type active': typeSlug === '', 'title-type': typeSlug !== '' }" href="/ecma/titulos">Todos</a>
                            <a v-for="type in types" :key="type.id" :class="{ 'title-type active': type.slug === typeSlug, 'title-type': type.slug !== typeSlug }" :href="routes('type', type.slug)">{{ type.name }}</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="all-titles">
                <div class="container">
                    <div class="grid-titles">
                        <div v-for="title in titles.data" :key="title.id" class="title-item">
                            <figure class="title-image">
                                <img v-if="title.images" :src="title.images.name" :alt="title.name">
                                <img v-else src="/assets/images/no_image.jpg" :alt="title.name">
                                <div class="overlayer" />
                            </figure>
                            <div class="title-info">
                                <div class="title-type">
                                    <a :href="routes('type', title.type.slug)">{{ title.type.name }}</a>
                                </div>
                                <h3 class="title-name">
                                    <a :href="routes('title', title.slug, title.type.slug)">{{ title.name }}</a>
                                </h3>
                            </div>
                        </div>
                    </div>
                    <div class="paginator" />
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import LoadingArticles from './Common/LoadingArticles/LoadingArticles'
import { routes } from '../mixins'

export default {
    name: 'EcmaTitles',
    components: {
        [LoadingArticles.name]: LoadingArticles
    },
    mixins: [routes],
    props: ['typeSlug'],
    data: function () {
        return {
            titles: 'No Info',
            types: 'No Info',
            themes: 'No Info',
            loading: false
        }
    },
    mounted() {
        this.getTitles()
        console.log(this.typeSlug)
    },
    methods: {
        realTimeSearch(e) {
            if (e.target.value !== '') {
                fetch(`https://coanime.net/api/v1/titles/${e.target.value}`)
                    .then(res => res.json())
                    .then((response) => {
                        console.log(response)
                    })
            }
        },
        search() {

        },
        getTitles() {
            this.loading = true

            if (this.typeSlug === '') {
                fetch(`/api/v1/titles`)
                    .then(res => res.json())
                    .then((response) => {
                        this.titles = response.result
                        this.types = response.types
                        this.themes = response.genres
                        this.loading = false
                    })
            } else {
                fetch(`/api/v1/titles/${this.typeSlug}`)
                    .then(res => res.json())
                    .then((response) => {
                        this.titles = response.result
                        this.types = response.types
                        this.themes = response.genres
                        this.loading = false
                    })
            }
        }
    }
}
</script>
