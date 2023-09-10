<template>
  <form>
    <v-text-field
        v-model="tour.name"
        label="Наименование тура"
        maxlength="50"
        outlined
        counter
        required
    ></v-text-field>
    <v-text-field
        v-model="tour.title"
        label="Краткое описание"
        maxlength="50"
        counter
        outlined
        required
    ></v-text-field>
    <v-select
        v-model="tour.categories"
        :items="categories"
        chips
        label="Категории"
        multiple
        outlined
    ></v-select>
    <TourFormMainPhoto
        :tour-id="tour.id"
        :main-photo="this.tourMainPhoto"
    />

    <v-btn
        class="mr-4"
        color="success"
        @click="updateInfo"
    >
      Сохранить
    </v-btn>

  </form>
</template>

<script>
import TourFormMainPhoto from "./TourFormMainPhoto";
import axiosInstance from "../requestService";

export default {
  name: "TourFormBanner",
  components: {
    TourFormMainPhoto
  },
  props: ['tourId', 'tourName', 'tourTitle', 'tourCategories', 'tourMainPhoto'],
  data: function () {
    return {
      tour: {
        id: this.tourId,
        name: this.tourName,
        title: this.tourTitle,
        categories: this.tourCategories,
      },
      categories: []
    }
  },
  mounted() {
    console.log('mounted tourFormBanner')
    this.getCategories()
  },
  methods: {
    getCategories(){
      axiosInstance.get(`/api/get-categories`)
          .then((response) => {
            this.categories = response.data
          })
          .catch((response) => {
            console.error(response)
            alert("Ошибка загрузки категорий");
          })
    },
    updateInfo(){
      axiosInstance.post(`/api/tour/update-banner-info`, this.tour)
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

<style scoped>

</style>