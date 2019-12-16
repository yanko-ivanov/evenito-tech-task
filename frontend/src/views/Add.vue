<template>
  <div class="container about">
    <div v-if="showSuccessMsg">
      Success! Now go see what the others have uploaded! :)
    </div>
    <form class="form" method="post" action="/add">
      <h1>Add your new video link</h1>
      <fieldset class="form-group">
        <label for="url">Paste the video url:</label>
        <input
          id="url"
          type="text"
          v-model="url"
          placeholder="Paste url here"
          class="form-control"
        />
      </fieldset>
      <fieldset class="form-group">
        <label for="title">Title:</label>
        <input
          id="title"
          v-model="title"
          type="text"
          placeholder="Title your video"
          class="form-control"
        />
      </fieldset>
      <fieldset class="form-group">
        <label for="desc">Description:</label>
        <textarea
          id="desc"
          v-model="description"
          placeholder="Describe it"
          class="form-control"
        ></textarea>
      </fieldset>
      <fieldset class="form-group">
        <label for="title">Duration:</label>
        <input
          id="duration"
          v-model="duration"
          type="text"
          placeholder="in seconds!"
          class="form-control"
        />
      </fieldset>
      <fieldset class="form-group">
        <label for="title">Thumbnail source:</label>
        <input
                id="thumb"
                v-model="thumb"
                type="text"
                placeholder="Urls only please"
                class="form-control"
        />
      </fieldset>
      <fieldset class="form-group">
        <label for="title">Keywords:</label>
        <input
          id="keywords"
          v-model="keywordsString"
          type="text"
          placeholder="separate them with commas"
          class="form-control"
        />
        <ul v-if="keywords.length > 0" class="keywords">
          <li :key="keyword" v-for="keyword in keywords">{{ keyword }}</li>
        </ul>
      </fieldset>
      <div class="form-actions">
        <button
          @click="saveVideo()"
          type="button"
          class="btn btn-primary btn-block"
        >
          Share with others!
        </button>
      </div>
    </form>
  </div>
</template>
<script>
export default {
  name: "Add",
  data: function() {
    return {
      title: "",
      description: "",
      thumb: "",
      url: "",
      duration: 0,
      keywordsString: "",
      showSuccessMsg: false,
    };
  },
  computed: {
    keywords: {
      // we want to separate them for .. some later stage. don't know if I'll have the time though
      get: function() {
        return (
          this.keywordsString.length > 0 &&
          this.keywordsString.replace(/\s/g, "").split(",")
        );
      },
      set: function(keywords) {
        this.keywordsString =
          keywords.length > 0 ? keywords.replace(/\s/g, "").split(",") : "";
      }
    }
  },
  methods: {
    saveVideo() {
      this.axios
        .post("http://0.0.0.0/video", {
          url: this.url,
          description: this.description,
          title: this.title,
          thumb: this.thumb,
          duration: this.duration
        })
        .then(data => {
          if(data.success === true) {
            this.showSuccessMsg = true;
          }
        });
    }
  }
};
</script>
<style>
.keywords {
}

.keywords li {
  list-style: none;
  padding: 3px;
  border-radius: 3px;
  border: 1px solid #333;
  background: #333;
  color: #fff;
  display: inline-block;
  margin-left: 3px;
}
</style>
