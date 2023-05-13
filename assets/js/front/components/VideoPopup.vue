<template>
  <div class="container">
    <div class="trailer__iframe">
  <div class="video-popup">
    <div class="video-frame">
      <youtube :video-id="videoId" :player-vars="{ autoplay: 1 }"></youtube>
    </div>
    <button class="close-button" @click="closePopup">Close</button>
  </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "VideoPopup",
  props: ['videoId'],
  data() {
    return {
      playerVars: {
        autoplay: 1,
      },
    };
  },
  methods: {
    closePopup() {
      this.$emit('close');
    },
  },
};
</script>

<style scoped>
.video-popup {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background-color: rgba(0, 0, 0, 0.8);
  display: flex;
  justify-content: center;
  align-items: center;
}

.video-frame {
  position: relative;
  padding-bottom: 56.25%;
  height: 0;
  overflow: hidden;
}

.close-button {
  position: absolute;
  top: 10px;
  right: 10px;
  padding: 5px 10px;
  background-color: white;
  color: black;
  border: none;
}
</style>
