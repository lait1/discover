<template>
  <div>
    <LoaderLocal
        v-if="loading"
        class="tour__review-loader"
        :size="100"
        :min-width="100"
    />
    <FunctionalCalendar
        v-else
        v-model="selectedDate"
        :configs="calendarConfigs"
        :disabled-dates="disabledDates"
        @choseDay="choseDate"
    ></FunctionalCalendar>
    <OrderDialog
        v-if="! loading"
        v-model="this.showOrderDialog"
        :trip-id="this.tripId"
        :selected-date="this.selectedDate"
        :price="this.price"
        :disable-date="calendarConfigs.disabledDates"
        @closeDialog="closeDialog"
        @showSuccessMessage="showSuccessMessage"
        @showErrorMessage="showErrorMessage"
    />
    <AlertDialog
        v-model="this.showAlert"
        :message="this.alertMessage"
        :has-error="this.hasError"
        @closeAlert="closeAlert"
      />
  </div>
</template>

<script>
import {FunctionalCalendar} from "vue-functional-calendar";
import OrderDialog from "./OrderDialog";
import AlertDialog from "./AlertDialog";
import axios from "axios";
import LoaderLocal from "./LoaderLocal";

export default {
  name: "Calendar",
  components: {
    FunctionalCalendar, OrderDialog, AlertDialog, LoaderLocal
  },
  props:['tripId', 'price'],
  data: () => ({
    showOrderDialog: false,
    selectedDate: {},
    calendarConfigs: {
      monthNames: ["Янв.", "Фев.", "Март", "Aпр.", "May", "Июнь", "Июль", "Авг.", "Сен.", "Октябрь", "Ноя.", "Дек."],
      dayNames: ['Пн', 'Вт', 'Ср', 'Чт', 'Пт', 'Сб', 'Вс'],
      calendarsCount: 2,
      isDatePicker: true,
      isMultiple: true,
      disabledDates: []
    },
    disabledDates: ['beforeToday'],
    showAlert: false,
    hasError: false,
    loading: false,
    alertMessage: ''
  }),
  created () {
    this.getUnavailableDates()
  },
  methods: {
    choseDate(date) {
      this.showOrderDialog = true
    },
    closeDialog() {
      this.showOrderDialog = false
    },
    closeAlert(){
      this.showAlert = false
    },
    showSuccessMessage(message) {
      this.closeDialog()

      this.showAlert = true
      this.alertMessage = message
    },
    showErrorMessage(errorMessage) {
      this.closeDialog()

      this.showAlert = true
      this.hasError = true
      this.alertMessage = errorMessage
    },
    getUnavailableDates() {
      this.loading = true
      axios.get('/order/get-unavailable-dates')
          .then((response) => {
            console.log(response.data)
            this.calendarConfigs.disabledDates = response.data
          })
          .catch((error) => {
            if (error.response.status === 400) {
              this.errorRequest(error.response.data.error)
              return
            }

            this.errorRequest('У нас технические трудности, попробуйте позднее')
          })
          .finally(() => {
            this.loading = false
          });
    },
  },
}
</script>

<style scoped>

</style>