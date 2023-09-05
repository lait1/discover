<template>
  <div class="tour-form__photos">
    <h3 class="tour-form__header">Фотографии:</h3>
    <v-file-input
        small-chips
        multiple
        show-size
        accept="image/png, image/jpeg, image/jpg"
        label="Фотографии для галлереи"
        @change="previewImages"
    ></v-file-input>
    <draggable
        :list="imagesList"
        class="tour-form__photo add-photo"
    >
      <div class="tour-form__photo-thumbnail" v-for="(image, index) in imagesList">
        <img :title="image.name" :src="image.path" :alt="image.name">
        <button
            @click.prevent="removePhoto(image.id, index)"
            v-bind:data-id="image.id"
            type="button"
            class="delete fa fa-remove">
        </button>
      </div>

    </draggable>
  </div>
</template>

<script>
import axiosInstance from "../requestService";
import draggable from 'vuedraggable'

export default {
  name: "TourFormPhotos",
  components: {
    draggable,
  },
  props:['tourId', 'imagesData'],
  data: function () {
    return {
      imagesList: this.imagesData,
    }
  },
  methods: {
    previewImages(files) {
      if (files.length === 0){
        return
      }

      let formData = new FormData();
      for (let i = 0; i < files.length; i++) {
        formData.append(`file${i}`, files[i]);
      }

      this.createPhoto(formData);
    },
    createPhoto(formData) {
      axiosInstance.post(`/api/tour/upload-photo/${this.tourId}`, formData)
          .then((response) => {
            if (response.data.message === 'success'){
              response.data.photos.forEach(item => {
                this.imagesList.push(item);
              });
            }
          })
          .catch((response) => {
            console.error(response)
            alert("Ошибка загрузки фотографий");
          });
    },
    removePhoto(id, index) {
      axiosInstance.post(`/api/tour/remove-photo/${id}`)
          .then((response) => {
            if (response.data.message === 'success'){
              this.imagesList.splice(index, 1)
            }
          })
          .catch((response) => {
            console.error(response)
            alert("Ошибка удаления фотографии");
          });
    },
  },
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
      max-height: 130px;
      max-width: 170px;
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