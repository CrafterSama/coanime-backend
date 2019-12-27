
<template>
    <div class="content-wrapper">
        <loading-articles v-if="loading" />
        <div v-else id="title">
            <div class="title-header">
                <figure class="title-header-image">
                    <img v-if="!randomImage" :src="title.images.name" :alt="title.name">
                    <img v-else :src="randomImage" :alt="title.name">
                </figure>
                <div class="overlayer" />
            </div>
            <div class="title-content">
                <div class="title-info container">
                    <div class="title-top-box overlap-banner">
                        <figure class="title-image overlap-banner">
                            <img :src="title.images.name" :alt="title.name">
                        </figure>
                        <div class="title-info-box">
                            <div class="title-name-box overlap-banner">
                                <h1 class="title-name">
                                    {{ title.name }}
                                </h1>
                            </div>
                            <ul class="title-info-details overlap-banner">
                                <li>
                                    <i class="fas fa-shapes" />
                                    <span>
                                        <span class="text-strong">Tipo:</span>
                                        <span class="info-details-type">
                                            <a :href="routes('type', title.type.slug)">{{ title.type.name }}</a>
                                        </span>
                                    </span>
                                </li>
                                <li>
                                    <i class="fas fa-language" /> <span><span class="text-strong">Otros Títulos:</span> {{ title.other_titles }}</span>
                                </li>
                                <li>
                                    <i class="fas fa-calendar" />
                                    <span>
                                        <span class="text-strong">Emitida desde:</span>&nbsp;
                                        <vue-moment :timestamp="title.broad_time" :format="'LL'" />&nbsp;-&nbsp;
                                        <span class="text-strong">Hasta el:</span>&nbsp;
                                        <span v-if="title.broad_finish === null">Sin Información precisa</span>
                                        <vue-moment v-else :timestamp="title.broad_finish" :format="'LL'" />
                                    </span>
                                </li>
                                <li>
                                    <i class="fas fa-tags" />
                                    <span>
                                        <span class="text-strong">Generos:</span>
                                        <span v-for="genre in title.generes" :key="genre.id" class="genre-tag">
                                            <a :href="routes('genre', genre.slug)">{{ genre.name }}</a>
                                        </span>
                                    </span>
                                </li>
                                <li>
                                    <i class="fas fa-list" />
                                    <span>
                                        <span class="text-strong">Episodios / Tomos / Capitulos:</span>
                                        <span v-if="title.episodies === ''">Sin Información precisa <span class="title-status">{{ title.status }}</span></span>
                                        <span v-else>{{ title.episodies }} <span class="title-status">{{ title.status }}</span></span>
                                    </span>
                                </li>
                                <li>
                                    <i class="fas fa-users" /> <span><span class="text-strong">Clasificación:</span> {{ title.rating.name }} ({{ title.rating.description }})</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="title-sinopsis"
                         v-html="title.sinopsis"
                    />
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import LoadingArticles from './Common/LoadingArticles/LoadingArticles'
import TimeAgo from './TimeAgo'
import VueMoment from './VueMoment'
import { routes } from '../mixins'

export default {
    name: 'EcmaTitle',
    components: {
        [TimeAgo.name]: TimeAgo,
        [VueMoment.name]: VueMoment,
        [LoadingArticles.name]: LoadingArticles
    },
    mixins: [routes],
    props: ['type', 'slug'],
    data: function () {
        return {
            title: 'Without Info',
            randomImage: 'Without Info',
            posts: 'Without Info',
            boxes: false,
            loading: false
        }
    },
    mounted() {
        this.getTitle()
        this.getRandomTitleImage()
        this.getTitlePosts()
    },
    methods: {
        postImage(str) {
            return str.replace('1920', '480')
        },
        getTitle() {
            this.loading = true
            fetch(`https://coanime.net/api/v1/titles/${this.type}/${this.slug}`)
                .then(res => res.json())
                .then(response => {
                    this.title = response.data
                    this.loading = false
                })
                .catch(error => console.log(error))
        },
        getRandomTitleImage() {
            fetch(`https://coanime.net/api/v1/random-image-title/${this.slug}`)
                .then(res => res.json())
                .then(response => {
                    if (response.message === 'OK') {
                        this.randomImage = response.image
                    } else {
                        this.randomImage = false
                    }
                    this.loading = false
                })
                .catch(error => console.log(error))
        },
        getTitlePosts() {
            this.loading = true
            fetch(`https://coanime.net/api/v1/titles/${this.type}/${this.slug}/posts`)
                .then(res => res.json())
                .then(response => {
                    this.posts = response
                })
                .catch(error => console.log(error))
        },
        changeGrid() {
            this.boxes = !this.boxes
        }
    }
}
</script>
