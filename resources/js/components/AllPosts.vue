
<template>
  <div class="posts-box">
    <div :class="{ boxes: boxes, lists: !boxes }">
      <article v-for="article in articles.data" :key="article.id" class="news">
        <figure class="news-image">
          <a :href="url('posts', article.slug)">
            <img :src="postImage(article.image)" :alt="article.title" />
          </a>
        </figure>
        <header class="news-header-box">
          <div class="news-category">
            <a
              class="dark-gray-text"
              :href="url('category', article.categories.slug)"
            >{{ article.categories.name }}</a>
          </div>
          <h2 class="news-title">
            <a :href="url('posts', article.slug)">{{ article.title }}</a>
          </h2>
          <div class="news-subtitle">{{article.excerpt}}</div>
          <small class="small">
            <i class="fas fa-user"></i>
            <span>
              <a
                class="orange-text"
                :href="url('user', article.users.slug)"
              >{{ article.users.name }}</a>
            </span>
            <i class="fas fa-clock"></i>
            <span>
              <time-ago>{{ article.postponed_to }}</time-ago>
            </span>
          </small>
        </header>
      </article>
    </div>
    <div class="more-button">
      <div v-if="loading === true">
        <FacebookLoader :color="color" />
      </div>
      <button v-on:click="getMorePosts(articles.next_page_url, $event)" type="button">
        <i class="fas fa-plus"></i> Mas Posts
      </button>
    </div>
  </div>
</template>
<script>
import TimeAgo from "./TimeAgo";
import { FacebookLoader } from "vue-spinners-css";

export default {
  name: "all-posts",
  data: function() {
    return {
      articles: "Without Articles",
      boxes: false,
      loading: false,
      color: "#ED6A00"
    };
  },
  methods: {
    url(type, slug) {
      if (type === "posts") {
        return "/posts/" + slug;
      }
      if (type === "category") {
        return "/categorias/" + slug;
      }
      if (type === "user") {
        return "/users/profile/" + slug;
      }
    },
    postImage(str) {
      return str.replace("1920", "480");
    },
    getPosts() {
      this.loading = true;
      fetch(`https://coanime.net/api/v1/articles`)
        .then(res => res.json())
        .then(response => {
          this.articles = response;
          this.loading = false;
        })
        .catch(error => console.log(error));
    },
    getMorePosts(url) {
      this.loading = true;
      fetch(`${url}`)
        .then(res => res.json())
        .then(response => {
          let items = articles.data;
          items.push(...response.data);
          let data = { ...response, data: items };
          this.articles = data;
          this.loading = false;
        })
        .catch(error => console.log(error));
    }
  },
  mounted() {
    this.getPosts();
  },
  components: {
    [TimeAgo.name]: TimeAgo,
    [FacebookLoader.name]: FacebookLoader
  }
};
</script>
