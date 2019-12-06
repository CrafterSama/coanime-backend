<template>
  <span class="post-date">{{ date }}</span>
</template>

<script>
import moment from "moment";
import "moment/locale/es";

export default {
  name: "time-ago",
  computed: {
    date() {
      return moment(this.$slots.default[0].text).fromNow();
    }
  }
};
</script>
