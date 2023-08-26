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
    />
  </div>
</template>

<script>
import {FunctionalCalendar} from "vue-functional-calendar";
import OrderDialog from "./OrderDialog";

export default {
  name: "Calendar",
  components: {
    FunctionalCalendar, OrderDialog
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
    }
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
  },
}
</script>

<style scoped>

</style>