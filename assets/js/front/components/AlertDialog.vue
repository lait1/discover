<template>
  <v-app class="comment__dialog-alert">
    <v-dialog v-model="showAlert" @click:outside="closeAlert" max-width="550px" attach=".comment__dialog-alert">
      <v-alert
          prominent
          outlined
          :type="alertType"
          :icon="alertIcon"
      >
        {{ this.message }}
      </v-alert>
    </v-dialog>
  </v-app>
</template>

<script>
export default {
  name: "Alertdialog",
  props:['value', 'message', 'hasError'],
  computed: {
    alertType(){
      if (this.hasError){
        return 'error'
      }
      return 'success'
    },
    alertIcon(){
      if (this.hasError){
        return 'fa-circle-exclamation'
      }
      return 'fa-circle-check'
    },
    showAlert() {
      return this.value
    },
  },
  methods: {
    closeAlert() {
      this.$emit('closeAlert');
    },
  },
};
</script>

<style scoped lang="scss">
::v-deep .v-card {
  display: flex;
  padding: 32px;
  flex-direction: column;
}
::v-deep .v-application--wrap {
  min-height: fit-content;
}
::v-deep .v-dialog{
  background: #FFF;
  .v-alert{
    margin-bottom: 0;
  }
}
::v-deep .vue-star-rating{
  gap: 8px;
}
</style>