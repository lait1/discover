<template>
  <lightbox :items="this.imageList" :cells="3"></lightbox>
</template>

<script>

export default {
  name: "Tourgallery",
  props:['imageList'],
  data () {
    return {
      images: this.imageList,
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