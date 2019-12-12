
<template>
  <div id="news" class="boxed-container">
    <h3 class="section-title orange-border-bottom">
      <i class="fas fa-plus"></i>
      Articulos
      <span class="put-to-right">
        <i class="fas fa-list"></i>
      </span>
    </h3>
    <div class="posts-box">
      <div :class="{ 'card-columns': boxes, lists: !boxes }">
        <article v-for="article in articles.data" :key="article.id" class="card">
          <figure class="card-img-top">
            <a :href="url('posts', article.slug)">
              <img :src="postImage(article.image)" :alt="article.title" />
            </a>
          </figure>
          <header class="card-body">
            <div class="card-category">
              <a :href="url('category', article.categories.slug)">{{ article.categories.name }}</a>
            </div>
            <h3 class="card-title">
              <a :href="url('posts', article.slug)">{{ article.title }}</a>
            </h3>
            <div class="card-text">
              <span class="card-subtitle">{{ article.excerpt }}</span>
            </div>
            <small class="card-text">
              <i class="fas fa-user"></i>
              <span class="card-author">
                <a :href="url('user', article.users.slug)">{{ article.users.name }}</a>
              </span>
              <i class="fas fa-clock"></i>
              <time-ago>{{ article.postponed_to }}</time-ago>
            </small>
          </header>
        </article>
      </div>
      <div class="button-spinner-section">
        <div v-if="loading">
          <div class="loading">
            <div class="fa-3x">
              <i class="fas fa-circle-notch fa-spin"></i>
            </div>
          </div>
        </div>
        <div v-else>
          <div class="more-section">
            <button
              v-on:click="getMorePosts(articles.next_page_url)"
              type="button"
              class="btn-block"
            >
              <i class="fas fa-sync-alt"></i> Mas Posts
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import TimeAgo from "./TimeAgo";

export default {
  name: "all-posts",
  data: function() {
    return {
      articles: "Without Articles",
      boxes: true,
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
          let items = this.articles.data;
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
    [TimeAgo.name]: TimeAgo
  }
};
</script>
