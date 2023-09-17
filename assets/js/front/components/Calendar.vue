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
      monthNames: ["Январь", "Февраль", "Март", "Апрель", "May", "Июнь", "Июль", "Август", "Сентябрь", "Октябрь", "Ноябрь", "Декабрь"],
      dayNames: ['Пн', 'Вт', 'Ср', 'Чт', 'Пт', 'Сб', 'Вс'],
      calendarsCount: 2,
      isDatePicker: true,
      isMultiple: true,
      disabledDates: ['beforeToday']
    },
    showAlert: false,
    hasError: false,
    loading: false,
    alertMessage: ''
  }),
  created () {
    this.getUnavailableDates()
    this.calendarConfigs.calendarsCount = this.$vuetify.breakpoint.width > 1024 ? 2 : 1 ;
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
      this.hasError = false
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

<style scoped lang="scss">

::v-deep .vfc-week {
  gap: 8px;
  height: 70px;
  .vfc-day{
    align-items: center;
    justify-content: center;
    border-radius: 8px;
    border: 2px solid var(--border-primary, #E3E6EE);
    span.vfc-span-day{
      color: var(--content-dark, #1C1D20);
      text-align: center;
      font-family: 'Oswald', sans-serif;
      font-size: 24px;
      font-weight: 400;
      line-height: 28px;
      border-radius: 0;
      display: flex;
      width: 100%;
      height: 100%;
      align-items: center;
      justify-content: center;
    }
    .vfc-disabled{
      background: var(--background-primary, #F6F6FA);
    }
  }
}
::v-deep .vfc-top-date {
  color: var(--content-dark, #1C1D20);
  text-align: center;
  font-family: 'Oswald', sans-serif;
  font-size: 24px;
  font-style: normal;
  font-weight: 500;
  line-height: 28px;
}
::v-deep .vfc-dayNames {
  margin-bottom: 4px;

  span {
    text-transform: uppercase;
    color: var(--content-accent-disable, #898998);
    font-family: Manrope, sans-serif;
    text-align: center;
    font-size: 16px;
    font-weight: 400;
    line-height: 24px;
    letter-spacing: 0.12px;
  }
}
</style>