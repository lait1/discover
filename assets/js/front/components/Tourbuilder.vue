<template>
  <v-app >
    <img src="/build/images/cloud_bg_trip_builder.png" alt="cloud" class="trip-builder__cloud">
    <div class="wrap">
      <div class="trip-builder__content">
        <div class="trip-builder__header">
          НЕТ ПОДХОДЯЩЕГО ТУРА? СОЗДАЙТЕ СВОЙ!
        </div>
        <svg class="icon">
          <use xlink:href="#lightning"></use>
        </svg>
        <div class="trip-builder__title">
          Выберите интересующие темы и укажите ваш номер телефона. Мы подберем экскурсию и свяжемся с вами!
        </div>
        <button class="trip-builder__button_chose-tour" @click="showDialog=true">Собрать тур</button>
      </div>

      <template v-for="tooltip in tooltips">
        <svg
            class="trip-builder__tooltip icon"
             v-tooltip="{content: tooltip.content, delay:{ hide: 500 }}"
            :style="{
                top: tooltip.top,
                left: tooltip.left
            }"
        >
          <use xlink:href="#tooltip"></use>
        </svg>
      </template>
      <TourBuilderDialog
          v-model="this.showDialog"
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
  </v-app>
</template>

<script>


import TourBuilderDialog from "./TourBuilderDialog";
import AlertDialog from "./AlertDialog";

export default {
  name: "Tourbuilder",
  components:{
    TourBuilderDialog, AlertDialog
  },
  data () {
    return {
      showDialog: false,
      showAlert: false,
      hasError: false,
      alertMessage: '',
      tooltips: [
        {
          top: '50%',
          left: '50%',
          content: '<span class="tooltip-content">Тур в горы <br>\n' +
              ' <a href="#" class="trip-builder__link">Посмотрет больше</a></span>'
        },
        {
          top: '50%',
          left: '60%',
          content: '<span class="tooltip-content">Тур в горы <br>\n' +
              ' <a href="#" class="trip-builder__link">Посмотрет больше</a></span>'
        }
      ],
    }
  },
  methods:{
    closeDialog() {
      this.showDialog = false
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
  }
};
</script>

<style scoped lang="scss">
.v-application a {
    color: #ffffff;
}
.trip-builder__tooltip{
  display: none;
  position: absolute;
  width: 40px;
  height: 40px;
  cursor: pointer;
  top: 50%;
  left: 50%;
}
</style>