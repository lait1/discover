<template>
  <div class="wrap">
    <div class="order__banner">
      <h2>Создайте незабываемый вечер</h2>
      <p>Планируете корпоративный праздник? Напишите нам, и мы учтем ваши <br> пожелания, предложим концепты, и составим смету</p>
      <button class="corporate__button_chose-tour" @click="showOrderDialog=true">ОСТАВИТЬ ЗАЯВКУ</button>
      <OrderCompanyDialog
          v-model="this.showOrderDialog"
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
  </div>
</template>

<script>
import OrderCompanyDialog from "./OrderCompanyDialog";
import AlertDialog from "./AlertDialog";
export default {
  name: "Corporate",
  components: {OrderCompanyDialog, AlertDialog},
  data: () => ({
    showOrderDialog: false,
    loading: false,
    showAlert: false,
    hasError: false,
    alertMessage: ''
  }),
  methods: {
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

  }
}
</script>

<style scoped>

</style>