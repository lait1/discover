<template>
  <v-app id="inspire">
      <v-row class="gallery__list">
        <template v-for="image in items" >

          <v-col v-if="image.children" cols="4" class="d-flex flex-column">
            <v-row>
              <v-col v-for="children in image.children" :key="children.id" :cols="children.cols">
                <div v-if="children.empty" class="gallery__photo empty">
                  <span>Здесь может быть ваше фото!</span>
                </div>
                <v-img
                    v-else
                    :src="children.src"
                    class="gallery__photo"
                    cover
                    height="100%"
                    @click="openPopup(children.id)"
                ></v-img>
              </v-col>
            </v-row>
          </v-col>

          <v-col :cols="image.cols">
            <v-img
                :src="image.src"
                class="gallery__photo"
                cover
                height="100%"
                @click="openPopup(image.id)"
            ></v-img>
          </v-col>

        </template>
      </v-row>

    <v-dialog v-model="showPopup" max-width="900px">
      <v-carousel v-model="selectedItemIndex">
        <v-carousel-item v-for="(item, index) in items" :key="index" cover>
          <v-card>
            <v-img :src="item.src"></v-img>
          </v-card>
        </v-carousel-item>
      </v-carousel>
    </v-dialog>

  </v-app>
</template>

<script>


export default {
  name: "Gallery",
  props: {
    message: String
  },
  data () {
    return {
      showPopup: false,
      selectedItemIndex: 0,
      items: [
        {
          id: 1,
          src: 'build/images/photos/photo1.jpeg',
          cols: 8,
          children: [{
            id: 6,
            cols: 12,
            src: 'build/images/photos/photo.png',
          }, {
            id: 7,
            cols: 12,
            empty: true,
          }]
        },
        {
          id: 2,
          src: 'build/images/photos/photo2.jpeg',
          cols: 8,
        },
        {
          id: 3,
          src: 'build/images/photos/photo1.jpeg',
          cols: 4,

        },
      ],
    }
  },
  methods: {
    openPopup(photoItem) {
      this.selectedItemIndex = photoItem
      this.showPopup = true;
    },
  },
}

</script>

<style scoped>

</style>