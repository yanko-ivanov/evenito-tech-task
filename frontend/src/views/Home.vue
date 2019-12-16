<template>
  <div class="container home">
    <router-link class="btn btn-primary" to="/add">
      Add new one?
    </router-link>
    <hr />
    Order by title:
    <select @change="fetchVideos" v-model="sortDirection">
      <option value="asc">Ascending</option>
      <option value="desc">Descending</option>
    </select>
    <hr />
    <div class="grid videos-wrapper">
      <Video :key="video.id" v-for="video in videos" :video="video" />
    </div>
  </div>
</template>

<script>
// @ is an alias to /src
import Video from "@/components/Video.vue";

export default {
  name: "home",
  data: function() {
    return {
      sortDirection: "asc",
      videos: [
        {
          title: "Hi",
          thumb_src: "https://picsum.photos/seed/picsum/400/100",
          url: "https://www.youtube.com/watch?v=Vqbk9cDX0l0"
        },
        {
          title: "Hi thar",
          thumb_src: "https://picsum.photos/400/100",
          url: "https://www.youtube.com/watch?v=Vqbk9cDX0l0"
        },
        {
          title: "Hi thar!!",
          thumb_src: "https://picsum.photos/400/100",
          url: "https://www.youtube.com/watch?v=Vqbk9cDX0l0"
        }
      ]
    };
  },
  components: {
    Video
  },
  created() {
    this.fetchVideos();
  },
  methods: {
    fetchVideos() {
      this.videos = [];
      this.axios
        .get(`http://0.0.0.0/videos?sort=${this.sortDirection}`)
        .then(resp => {

          this.videos = resp.data.results;
          console.log(resp.data.results);
        });
    }
  }
};
</script>
<style scoped>
.videos-wrapper {
  background: none #fafafa;
  box-shadow: 0px 0px 15px #cecece;
  border-radius: 4px;
  padding: 30px;
}
</style>
