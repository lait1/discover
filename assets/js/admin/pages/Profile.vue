<template>
  <v-container>
    <v-row
        class='justify-center'
        no-gutters
    >
      <v-card-title>
        <span class="text-h5">Мой календарь</span>
      </v-card-title>

      <v-card-text>
        <FunctionalCalendar
            ref="Calendar"
            v-model="selectedDate"
            :configs="calendarConfigs"
            @choseDay="setDates"
        ></FunctionalCalendar>
      </v-card-text>
    </v-row>
  </v-container>
</template>

<script>
import axiosInstance from "../requestService";
import {FunctionalCalendar} from "vue-functional-calendar";
import LoaderLocal from "../../front/components/LoaderLocal";

export default {
  name: "Profile",
  components: {
    FunctionalCalendar, LoaderLocal
  },
  data: () => ({
    loading: false,
    selectedDate: {},
    calendarConfigs: {
      monthNames: ["Январь", "Февраль", "Март", "Апрель", "Maй", "Июнь", "Июль", "Август", "Сентябрь", "Октябрь", "Ноябрь", "Декабрь"],
      dayNames: ['Пн', 'Вт', 'Ср', 'Чт', 'Пт', 'Сб', 'Вс'],
      calendarsCount: 2,
      isMultiple: true,
      isMultipleDatePicker: true,
      markedDates: [],
      disabledDates: ['beforeToday']
    },
  }),
  mounted() {
    this.$refs.Calendar.ChooseDate('today')

    this.getUnavailableDates()
    this.getMarkedDates()

  },
  methods: {
    getUnavailableDates() {
      axiosInstance.get(`/api/get-unavailable-dates`)
          .then((response) => {
            this.calendarConfigs.disabledDates = response.data
            this.$refs.Calendar.setConfigs()
          })
    },
    getMarkedDates() {
      axiosInstance.get(`/api/get-marked-dates`)
          .then((response) => {
            this.selectedDate.selectedDates = response.data
          })
    },
    setDates(date) {
      axiosInstance.post(`/api/toggle-dates`, date.date)
          .catch((response) => {
            console.error(response)
          })
    },
    close() {
      this.$router.push({path: `/admin/orders`});
    }
  }
}
</script>

<style scoped>

</style>