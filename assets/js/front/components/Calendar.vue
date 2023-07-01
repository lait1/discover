<template>
    <FunctionalCalendar
      v-model="calendarData"
      :configs="calendarConfigs"
      @choseDay="choseDate"
    ></FunctionalCalendar>
</template>

<script>
import {FunctionalCalendar} from "vue-functional-calendar";

export default {
  name: "Calendar",
  components: {
    FunctionalCalendar
  },
  data: () => ({
    calendarData: {},
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
      console.log(date.date)
    },
  },
}
</script>

<style scoped>

</style>