<template>
  <div>
    <FunctionalCalendar
        v-model="selectedDate"
        :configs="calendarConfigs"
        @choseDay="choseDate"
    ></FunctionalCalendar>
    <OrderDialog
        v-model="this.showOrderDialog"
        :trip-id="this.tripId"
        :selected-date="this.selectedDate"
        :price="this.price"
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

export default {
  name: "Calendar",
  components: {
    FunctionalCalendar, OrderDialog, AlertDialog
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
      disabledDates: ['beforeToday']
    },
    showAlert: false,
    hasError: false,
    alertMessage: ''
  }),
  mounted () {

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
  },
}
</script>

<style scoped>

</style>