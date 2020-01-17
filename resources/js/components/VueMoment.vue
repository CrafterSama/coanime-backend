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
            if (moment(this.timestamp).isValid()) {
                return moment(this.timestamp).format(this.format)
            } else {
                return 'Sin Información Precisa'
            }
        }
    }
}
</script>
