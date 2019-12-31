<template>
    <div class="title-item">
        <div v-show="hover" class="title-more-info">
            <h3 class="title-name">
                <a :href="routes('title', title.slug, title.type.slug)">{{ title.name }}</a>
            </h3>
            <p class="title-sinopsis">
                {{ title.sinopsis }}
            </p>
        </div>
        <figure class="title-image">
            <img v-if="title.images" :src="title.images.name" :alt="title.name">
            <img v-else src="/assets/images/no_image.jpg" :alt="title.name">
            <div :class="{'overlayer': !hover, 'overlayer hover': hover}" />
        </figure>
        <div class="title-info">
            <div class="title-type">
                <a :href="routes('type', title.type.slug)">
                    {{ title.type.name }}
                </a>
            </div>
            <h3 class="title-name">
                <a :href="routes('title', title.slug, title.type.slug)">{{ title.name }}</a>
            </h3>
        </div>
    </div>
</template>

<script>
import { routes } from '../../../mixins'
export default {
    name: 'TitleItem',
    mixins: [routes],
    props: ['title'],
    data: function () {
        return {
            hover: false
        }
    }
}
</script>

<style>

</style>
