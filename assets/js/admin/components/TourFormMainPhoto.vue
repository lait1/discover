<template>
  <div class="tour-form__photos">
    <v-file-input
        small-chips
        show-size
        outlined
        accept="image/png, image/jpeg, image/jpg"
        label="Добавить фото шапки тура"
        @change="previewImages"
    ></v-file-input>

    <div class="tour-form__photo">
      <div class="tour-form__photo-thumbnail" v-if="image">
        <img :src="image">
        <button
            @click.prevent="removePhoto()"
            type="button"
            class="delete fa fa-remove">
        </button>
      </div>
    </div>
  </div>
</template>

<script>
import axiosInstance from "../requestService";
import draggable from 'vuedraggable'

export default {
  name: "TourFormMainPhoto",
  components: {
    draggable,
  },
  props:['tourId', 'mainPhoto'],
  data: function () {
    return {
      image: this.mainPhoto,
    }
  },
  methods: {
    previewImages(file) {
      if (file.length === 0){
        return
      }

      let formData = new FormData();
      formData.append(`file`, file);

      this.createPhoto(formData);
    },
    createPhoto(formData) {
      axiosInstance.post(`/api/tour/upload-main-photo/${this.tourId}`, formData)
          .then((response) => {
            if (response.data.message === 'success'){
              this.image = response.data.path
            }
          })
          .catch((response) => {
            console.error(response)
            // alert("Ошибка загрузки фотографий");
          });
    },
    removePhoto() {
      axiosInstance.post(`/api/tour/unset-main-photo/${this.tourId}`)
          .then((response) => {
            if (response.data.message === 'success'){
              this.image = null
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