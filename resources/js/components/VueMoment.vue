<template>
    <span class="post-date">{{ date }}</span>
</template>

<script>
import moment from 'moment'
import 'moment/locale/es'

export default {
    name: 'VueMoment',
    props: ['timestamp', 'format'],
    computed: {
        date() {
            return moment(this.timestamp).format(this.format)
        }
    }
}
</script>
