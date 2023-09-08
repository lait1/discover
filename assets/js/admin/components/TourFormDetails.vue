<template>
  <form>
    <v-text-field
        v-model="tour.price"
        label="Цена"
        type="number"
        value="100"
        prefix="GEL"
    ></v-text-field>

    <v-select
        v-model="tour.includePrice"
        :items="options"
        label="Цена включает"
        multiple
        chips
    ></v-select>
    <v-select
        v-model="tour.excludePrice"
        :items="options"
        label="Не входит в стоимость"
        multiple
        chips
    ></v-select>
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
import axiosInstance from "../requestService";

export default {
  name: "TourFormDetails",
  props: ['tourId', 'tourPrice', 'tourIncludePrice', 'tourExcludePrice'],
  data: function () {
    return {
      tour: {
        id: this.tourId,
        price: this.tourPrice,
        includePrice: this.tourIncludePrice,
        excludePrice: this.tourExcludePrice,
      },
      options: []
    }
  },
  mounted() {
    this.getOptions()
  },
  methods: {
    getOptions(){
      axiosInstance.get(`/api/get-options/`)
          .then((response) => {
            this.options = response.data
          })
          .catch((response) => {
            console.error(response)
            alert("Ошибка загрузки категорий");
          })
    },
    updateInfo(){
      axiosInstance.post(`/api/tour/update-price-info/`, this.tour)
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