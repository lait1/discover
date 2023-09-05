<template>
  <v-card>
  <v-tabs
      v-model="selectedTab"
      color="deep-purple-accent-4"
      align-tabs="center"
  >
    <v-tab :value="1">Баннер</v-tab>
    <v-tab :value="2">Куда мы едем</v-tab>
    <v-tab :value="3">Что вас ожидает</v-tab>
    <v-tab :value="4">Стоимость</v-tab>
    <v-tab :value="5">FAQ</v-tab>
    <v-tab :value="6">SEO</v-tab>
  </v-tabs>

  <LoaderLocal
      v-if="loading"
      class="tour__review-loader"
      :size="100"
      :min-width="100"
  />
    <v-tabs-items v-else v-model="selectedTab">
      <v-tab-item>
        <TourFormLayout
            example-image="example-top.jpg"
        >
          <template v-slot:content  >
            <TourFormBanner
                :tour-id="tour.id"
                :tour-name="tour.name"
                :tour-title="tour.title"
                :tour-categories="tour.categories"
                :tour-main-photo="tour.mainPhoto"
            />
          </template>
        </TourFormLayout>

      </v-tab-item>
      <v-tab-item>
        <h1>Куда мы едем</h1>
      </v-tab-item>
      <v-tab-item>
        <h1>что вас ждет</h1>

      </v-tab-item>
      <v-tab-item>
        <h1>стоимость</h1>
      </v-tab-item>
      <v-tab-item>
        <h1>FAQ</h1>
      </v-tab-item>
      <v-tab-item>
        <h1>SEO</h1>
      </v-tab-item>
    </v-tabs-items>
  </v-card>
</template>

<script>
import TourFormLayout from "../components/TourFormLayout";
import axiosInstance from "../requestService";
import TourFormBanner from "../components/TourFormBanner";
import LoaderLocal from "../components/LoaderLocal";

export default {
  name: "TourEdit",
  components: {TourFormLayout, TourFormBanner, LoaderLocal},
  data: function () {
    return {
      selectedTab: 0,
      loading: false,
      tour: {}
    }
  },
  mounted() {
    this.getTourInfo()
  },
  methods: {
    getTourInfo(){
      this.loading = true
      axiosInstance.get(`/api/tour/get-tour-info/${this.$route.params.id}`)
          .then((response) => {
            this.tour = response.data
          })
          .catch((response) => {
            console.error(response)
            alert("Fail get info by tour");
          })
          .finally(() => {
            this.loading = false
          });
    }
  }
}
</script>

<style scoped>

</style>