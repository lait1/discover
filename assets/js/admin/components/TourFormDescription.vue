<template>
<div class="tour-form__description">
  <v-btn
      class="mb-4"
      color="primary"
      @click="addNewDesc()"
  >
    Добавить блок
  </v-btn>
  <v-row v-for="(description, index) in tour.descriptions" :key="index">
    <v-col cols="10">
      <v-text-field
          label="Заголовок"
          v-model="description.header"
          maxlength="50"
          counter
          outlined
          required
      ></v-text-field>
      <v-textarea
          label="Полное описание"
          v-model="description.content"
          maxlength="550"
          counter
          outlined
          required
      ></v-textarea>

    <TourFormDescriptionImage
        :imageIdTour="index"
        :imageTour="description.image"
        @changeImage="changeImage"
      />

    </v-col>
    <v-col cols="2">
      <v-btn
          class="ma-2"
          fab
          dark
          small
          color="red"
          @click="removeDesc(index)"
      >
        <v-icon dark>
          mdi-minus
        </v-icon>
      </v-btn>

      <v-btn
          class="ma-2"
          fab
          dark
          small
          color="success"
          @click="saveInfo(index)"
      >
        <v-icon dark>
          mdi-content-save
        </v-icon>
      </v-btn>

    </v-col>
  </v-row>
</div>
</template>

<script>
import axiosInstance from "../requestService";
import TourFormDescriptionImage from "./TourFormDescriptionImage";

export default {
  name: "TourFormDescription",
  props: ['tourId', 'tourDescriptions'],
  components: {
    TourFormDescriptionImage
  },
  data: function () {
    return {
      imageUrl: null,
      tour: {
        id: this.tourId,
        descriptions: [],
      },
    }
  },
  mounted() {
    if (this.tourDescriptions.length > 0) {
      this.tour.descriptions = this.tourDescriptions
    } else {
      this.addNewDesc()
    }
  },
  methods: {
    changeImage(imageInfo){
      this.tour.descriptions[imageInfo.descId].image = imageInfo.file
    },
    addNewDesc(){
      this.tour.descriptions.push(
        {
          id: 0,
          header: '',
          content: '',
          image: null,
        }
      )
    },
    removeDesc(index){
      this.tour.descriptions.splice(index, 1)
    },
    saveInfo(index){

      let data = new FormData();
      data.append('id', this.tour.descriptions[index].id);
      data.append('tourId', this.tour.id);
      data.append('header', this.tour.descriptions[index].header);
      data.append('content', this.tour.descriptions[index].content);
      data.append('image', this.tour.descriptions[index].image);

      axiosInstance.post(`/api/tour/update-desc-info`, data)
          .then((response) => {
            if (response.data.message === 'success'){
              alert("Данные успешно обновлены");
            }
          })
          .catch((response) => {
            console.error(response)
            alert("Save tour failed");
          })
    }
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