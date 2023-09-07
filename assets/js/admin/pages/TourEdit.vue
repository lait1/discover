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
          <template #content  >
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
        <TourFormLayout
            example-image="example-where.jpg"
        >
          <template #content  >
            <TourFormWhereToGo
                :tour-id="tour.id"
                :tour-complexity="tour.complexity"
                :tour-long-time="tour.longTime"
                :tour-group-size="tour.groupSize"
                :tour-description="tour.description"
                :tour-images-data="tour.photos"
                :tour-youtube-link="tour.youtubeLink"
            />
          </template>
        </TourFormLayout>
      </v-tab-item>

      <v-tab-item>
        <TourFormLayout
            example-image="example-waiting.jpg"
        >
          <template #content  >
            <TourFormDescription
                :tour-id="tour.id"
                :tour-descriptions="tour.tourDescriptions"
            />
          </template>
        </TourFormLayout>
      </v-tab-item>

      <v-tab-item>
        <TourFormLayout
            example-image="example-price.jpg"
        >
          <template #content  >
            <TourFormDetails
                :tour-id="tour.id"
                :tour-price="tour.price"
                :tour-include-price="tour.includePrice"
                :tour-exclude-price="tour.excludePrice"
            />
          </template>
        </TourFormLayout>
      </v-tab-item>

      <v-tab-item>
        <TourFormLayout
            example-image="example-faq.jpg"
        >
          <template #content  >

          </template>
        </TourFormLayout>
      </v-tab-item>

    </v-tabs-items>
  </v-card>
</template>

<script>
import TourFormLayout from "../components/TourFormLayout";
import axiosInstance from "../requestService";
import TourFormBanner from "../components/TourFormBanner";
import LoaderLocal from "../components/LoaderLocal";
import TourFormDescription from "../components/TourFormDescription";
import TourFormWhereToGo from "../components/TourFormWhereToGo";
import TourFormDetails from "../components/TourFormDetails";

export default {
  name: "TourEdit",
  components: {TourFormWhereToGo, TourFormDetails, TourFormLayout, TourFormBanner, LoaderLocal, TourFormDescription},
  data: function () {
    return {
      selectedTab: null,
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