<template>
  <v-app >
  <div class="container">
    <img :src="image" alt="trailer" width="100%" class="trailer__banner" />

    <v-btn
        class="trailer__play pulse"
        fab
        @click="openVideoPopup"
    >
      <i class="fa fa-sharp fa-solid fa-circle-play"></i>
    </v-btn>

    <v-dialog v-model="showPopup" :max-width="900"  @click:outside="closeVideoPopup">
      <div class="trailer__video">
          <youtube ref="youtube" :fitParent="true" :resize="true"  :video-id="videoId" />
      </div>
    </v-dialog>
  </div>
  </v-app>
</template>

<script>


export default {
  name: "Trailer",
  props: ['videoId', 'image'],
  data() {
    return {
      showPopup: false,
    };
  },
  methods: {
    openVideoPopup() {
      this.showPopup = true;
    },
    closeVideoPopup() {
      this.$refs.youtube.player.stopVideo()
      this.showPopup = false;
    },
  },
};
</script>

<style scoped lang="scss">
::v-deep .v-application--wrap {
  min-height: fit-content;
}
</style>