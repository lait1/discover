<template>
  <lightbox :items="this.imageList" :cells="height"></lightbox>
</template>

<script>

export default {
  name: "Tourgallery",
  props:['imageList'],
  data () {
    return {
      images: this.imageList,
    }
  },
  computed: {
    height() {
      if (this.$vuetify.breakpoint.width <= 586) {
        return 1;
      }
      return 3
    }
  },
}

</script>

<style scoped lang="scss">
::v-deep .lb-grid {
  height: 600px;
  @media screen and (max-width: 765px) {
    height: 400px;
  }
  .lb-item:first-child {
    width: 64%;
    @media screen and (max-width: 568px) {
      width: 100%;
    }
  }

  .lb-item {
    border-radius: 24px;
    overflow: hidden;
    width: 35%;
  }
}

::v-deep .lb-grid-3 .lb-item:nth-child(2){
  height: 49%;
}

::v-deep .lb-grid-3 .lb-item:nth-child(3){
  height: 49%;
}
</style>