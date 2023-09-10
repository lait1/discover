<template>
  <div class="tour-form__photo">
    <v-file-input
        v-model="image.file"
        small-chips
        show-size
        accept="image/png, image/jpeg, image/jpg"
        @change="previewImage"
        @click:clear="clearImage()"
        label="Фото описания"
    ></v-file-input>

    <div v-if="imageUrl" class="tour-form__photo-thumbnail">
      <img :src="imageUrl">
    </div>
  </div>

</template>

<script>
export default {
  name: "TourFormDescriptionImage",
  props: ['imageTour', 'imageIdTour'],
  data: function () {
    return {
      image: {
        descId: this.imageIdTour,
        file: null
      },
      imageUrl: this.imageTour,
    }
  },
  mounted() {
    console.log(this.imageTour)
  },
  methods: {
    previewImage(event) {
      const file = event;

      if (file) {
        const reader = new FileReader();
        reader.onload = () => {
          this.imageUrl = reader.result;
        };
        reader.readAsDataURL(file);
        this.image.file = file
        this.$emit('changeImage', this.image);
      }
    },
    clearImage(){
      this.imageUrl = null
    },
  }
}
</script>

<style scoped lang="scss">
.tour-form {
  &__photo {
    display: flex;
    flex-direction: row;
    flex-wrap: wrap;

    &-thumbnail {
      margin: 5px;
      position: relative;
    }

    &:hover img {
      filter: brightness(40%);
    }

    &:hover button {
      display: block;
    }

    img {
      width: 100%;
      height: 100%;
      transition: .3s ease-in-out;
    }

    button {
      position: absolute;
      right: 5px;
      top: 5px;
      color: #fff;
      background: transparent;
      border: none;
      font-size: 20px;
      display: none;
    }
  }
}
</style>