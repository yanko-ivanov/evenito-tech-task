<template>
  <div class="cell -3of12 video">
    <div class="card">
      <header class="card-header">{{ video.name }}</header>
      <div class="card-content">
        <div class="inner">
          <div class="thumb">
            <img :src="video.thumb" />
          </div>
          <a :href="video.url">See more &raquo;</a>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "Video",
  props: {
    video: Object
  }
};
</script>

<style scoped>
.video {
  margin: 20px;
  border: 4px solid #fff;
  box-shadow: 0px 0px 15px #fefefe;
  border-radius: 4px;
}

.video .thumb img {
  width: 100%;
}
</style>
