<template>
  <v-dialog attach=".tour__review" v-model="showGalleryDialog" max-width="1200px" @click:outside="closeDialog">
    <v-carousel
        :value=selectedPhoto
        :hide-delimiters="true"
        height="100%"
    >
      <template v-slot:prev="{ on, attrs }">
        <v-btn
            class="mx-2 tour__review-gallery-btn"
            fab
            v-bind="attrs"
            v-on="on"
            small
        >
          <i class="fa-solid fa-circle-left"></i>
        </v-btn>
      </template>
      <template v-slot:next="{ on, attrs }">
        <v-btn
            class="mx-2 tour__review-gallery-btn"
            fab
            v-bind="attrs"
            v-on="on"
            small
        >
          <i class="fa-solid fa-circle-right"></i>
        </v-btn>
      </template>
      <v-carousel-item v-for="(item, index) in photos" :key="index" :value="item.id" cover>
        <v-card>
          <v-img :src="item.path"></v-img>
        </v-card>
      </v-carousel-item>
    </v-carousel>
  </v-dialog>
</template>

<script>
export default {
  name: "ReviewGallery",
  props:['value', 'photos', 'selectedItem'],
  computed: {
    showGalleryDialog() {
      return this.value
    },
    selectedPhoto() {
      return this.selectedItem
    },
  },
  methods: {
    closeDialog() {
      this.$emit('closeDialog');
    },
  }
}
</script>

<style scoped lang="scss">
::v-deep .v-window__next{
  right: 0;
}
.tour__review-gallery-btn{
  font-size: 26px;
}
::v-deep .v-application--wrap {
  min-height: fit-content;
}
</style>