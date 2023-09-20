<template>
  <div>
  <lightbox v-if="!showSlider" :items="this.imageList" :cells="height"></lightbox>
  <v-carousel v-if="showSlider" hide-delimiters>
    <template v-slot:prev="{ on, attrs }">
      <v-btn
          class="mx-2 tour__gallery-gallery-btn"
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
          class="mx-2 tour__gallery-gallery-btn"
          fab
          v-bind="attrs"
          v-on="on"
          small
      >
        <i class="fa-solid fa-circle-right"></i>
      </v-btn>
    </template>
    <v-carousel-item
        v-for="(item,i) in this.imageList"
        :key="i"
        :src="item"
    ></v-carousel-item>
  </v-carousel>
  </div>
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
    },
    showSlider() {
      return this.$vuetify.breakpoint.width <= 586;
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

::v-deep .v-window{
  border-radius: 32px;
  &__next{
    right: 0;
  }
}
.theme--dark.v-btn.v-btn--has-bg{
  background: transparent;
}
.tour__gallery-gallery-btn{
  font-size: 26px;
}
</style>