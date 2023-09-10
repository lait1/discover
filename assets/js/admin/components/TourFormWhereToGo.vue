<template>
  <form>
    <v-row>
      <v-col cols="4">
        <v-text-field
            v-model="tour.longTime"
            label="Длина тура"
            maxlength="20"
            counter
            outlined
            required
        ></v-text-field>
      </v-col>
      <v-col cols="4">
        <v-select
            v-model="tour.complexity"
            :items="complexity"
            label="Сложность"
            outlined
            required
        ></v-select>
      </v-col>
      <v-col cols="4">
        <v-text-field
            v-model="tour.groupSize"
            label="Размер группы"
            type="number"
            outlined
            value="1"
        ></v-text-field>
      </v-col>
    </v-row>

      <v-textarea
          v-model="tour.description"
          label="Полное описание"
          maxlength="400"
          counter
          outlined
          required
      ></v-textarea>

    <v-text-field
        v-model="tour.youtubeLink"
        label="YoyTube link code"
        outlined
    ></v-text-field>

    <TourFormPhotos
        :tour-id="tour.id"
        :images-data="imagesData"
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
import TourFormPhotos from "./TourFormPhotos";
import axiosInstance from "../requestService";

export default {
  name: "TourFormWhereToGo",
  components: {
    TourFormPhotos
  },
  props: ['tourId', 'tourComplexity', 'tourLongTime', 'tourGroupSize', 'tourDescription', 'tourImagesData', 'tourYoutubeLink'],
  data: function () {
    return {
      tour: {
        id: this.tourId,
        complexity: this.tourComplexity,
        longTime: this.tourLongTime,
        groupSize: this.tourGroupSize,
        description: this.tourDescription,
        youtubeLink: this.tourYoutubeLink,
      },
      imagesData: this.tourImagesData,
      complexity: [
        'hard',
        'medium',
        'easy',
      ],
    }
  },
  methods: {
    updateInfo(){
      axiosInstance.post(`/api/tour/update-where-to-go-info`, this.tour)
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