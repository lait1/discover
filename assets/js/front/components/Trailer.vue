<template>
  <v-app id="inspire">
  <div class="container">
    <img :src="image" alt="trailer" />

    <v-btn
        color="primary"
        fab
        large
        @click="openVideoPopup"
    >
      <v-icon x-large> mdi-play</v-icon>
    </v-btn>

    <v-dialog v-model="showPopup" :max-width="900"  @click:outside="closeVideoPopup">
      <div class="trailer__video">
          <youtube ref="youtube" :fitParent="true" :resize="true"  :video-id="videoId" :player-vars="playerVars" />
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
      playerVars: {

      },
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
