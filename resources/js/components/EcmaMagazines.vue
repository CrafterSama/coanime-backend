<template>
    <div class="titles-box">
        <loading-articles v-if="loading" />
        <div v-else>
            <div class="search-box">
                <div class="container">
                    <div class="boxed-container">
                        <form id="serch-form" class="search-form" autocomplete="off" @submit.prevent="search">
                            <div class="form-group d-flex justify-content-center">
                                <input class="form-control form-control-lg" autocomplete="off" type="text" name="search" placeholder="Busqueda de Revistas" @keyup="realTimeSearch" @blur="hide" @focus="show = true">
                            </div>
                            <div v-if="results.length > 0 && show" class="searching-results">
                                <div v-for="(item, index) in results" :key="index" class="result-item">
                                    <a :href="routes('magazine', item.slug)">
                                        <div class="result-item-url">
                                            <figure class="result-item-image">
                                                <img v-if="item.image.name" :src="routes('magazine-image', item.image.name)" :alt="`${item.name}`">
                                                <img v-else src="/assets/images/no_image.jpg" :alt="`${item.name}`">
                                            </figure>
                                            <div class="result-item-info">
                                                <h4 class="result-item-name">
                                                    {{ item.name }} ({{ item.type.name }})
                                                </h4>
                                                <p>
                                                    ({{ item.release.name }})
                                                </p>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                <button class="submit-search" type="submit">
                                    Ver todos los resultados para <span class="enfasis-underline">{{ searching }}</span>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="all-titles">
                <div v-if="load" class="container">
                    <div class="loading">
                        <div class="fa-3x">
                            <i class="fas fa-circle-notch fa-spin" />
                        </div>
                    </div>
                </div>
                <div v-else class="container">
                    <div class="grid-titles">
                        <div v-for="(magazine, index) in magazines.data" :key="index" class="title-item" @mouseover="hover = index" @mouseleave="hover = null">
                            <figure class="title-image">
                                <img v-if="magazine.image.name" :src="routes('magazine-image', magazine.image.name)" :alt="`${magazine.name}`">
                                <img v-else src="/assets/images/no_image.jpg" :alt="magazine.name">
                                <div :class="{'overlayer': hover !== index, 'overlayer hover': hover === index}">
                                    <a :href="routes('magazine', magazine.slug)" />
                                </div>
                            </figure>
                            <div class="title-info">
                                <div class="title-type">
                                    <p>
                                        {{ magazine.type.name }}
                                    </p>
                                </div>
                                <h3 class="title-name person">
                                    <a :href="routes('magazine', magazine.slug)">
                                        {{ magazine.name }}
                                    </a>
                                </h3>
                                <div class="genres-list">
                                    <p class="title-type">
                                        {{ magazine.release.name }}
                                    </p>
                                </div>
                            </div>
                            <div class="more-info">
                                <a :href="routes('magazine', magazine.slug)">
                                    <i class="fas fa-search-plus" />
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="paginator">
                        <div class="pages-info">
                            Pagina {{ magazines.current_page }} de
                            {{ magazines.last_page }} {{ magazines.last_page > 1 ? 'Paginas' : 'Pagina' }}
                        </div>
                        <div class="space-between" />
                        <div class="pages-links">
                            <span v-if="magazines.prev_page_url !== null" class="page-prev" @click="loadPage(magazines.prev_page_url)">
                                <i class="fas fa-chevron-left" />
                            </span>
                            <span v-if="magazines.next_page_url !== null" class="page-next" @click="loadPage(magazines.next_page_url)">
                                <i class="fas fa-chevron-right" />
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import EcmaNavbar from './Common/Ecma/EcmaNavbar'
import LoadingArticles from './Common/Loading/LoadingArticles'
import _ from 'lodash'
import { routes } from '../mixins'

export default {
    name: 'EcmaMagazines',
    components: {
        [LoadingArticles.name]: LoadingArticles,
        [EcmaNavbar.name]: EcmaNavbar
    },
    mixins: [routes],
    props: ['section'],
    data: function () {
        return {
            magazines: 'No Info',
            results: '',
            searching: '',
            show: false,
            hover: null,
            load: false,
            loading: false
        }
    },
    created() {
        this.getMagazines()
    },
    methods: {
        hide() {
            setTimeout(() => {
                this.show = false
            }, 1000)
        },
        realTimeSearch(e) {
            if (e.target.value !== '') {
                this.searching = e.target.value
                fetch(`/api/v1/search/magazine/${e.target.value}`)
                    .then(res => res.json())
                    .then(response => {
                        this.results = _.take(response.magazine.data, 10)
                    })
            }
        },
        search(e) {
            const form = e.target
            this.load = true
            fetch(`/api/v1/search/magazine/${e.target[0].value}`)
                .then(res => res.json())
                .then(response => {
                    this.results = ''
                    this.magazines = response.magazine
                    this.load = false
                    form.reset()
                })
        },
        loadPage(url) {
            this.load = true
            fetch(`${url}`)
                .then(res => res.json())
                .then(response => {
                    this.magazines = response.magazine
                    this.load = false
                })
        },
        getMagazines() {
            this.loading = true
            fetch(`/api/v1/magazine`)
                .then(res => res.json())
                .then(response => {
                    this.magazines = response.magazine
                    this.loading = false
                })
        }
    }
}
</script>
