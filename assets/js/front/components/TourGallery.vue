<template>
  <lightbox :items="images" :cells="3"></lightbox>
</template>

<script>

export default {
  name: "Tourgallery",
  props: {
    message: String
  },

  data () {
    return {
      images: [
        '/build/images/photos/photo1.jpeg',
        '/build/images/photos/photo.png',
        '/build/images/photos/photo2.jpeg',
        '/build/images/photos/photo1.jpeg',
        '/build/images/photos/photo1.jpeg',
        '/build/images/photos/photo2.jpeg',
        '/build/images/photos/photo1.jpeg',
        '/build/images/photos/photo1.jpeg',
      ],
      index: null
    }
  },
  methods: {
    openPopup(photoItem) {

    },
  },
}

</script>

<style scoped>

</style>