<template>
  <v-app >
    <v-dialog v-model="showAlert" @click:outside="closeAlert" max-width="550px">
      <v-card class="comment__dialog-alert">
          {{ this.message }}
      </v-card>
    </v-dialog>
  </v-app>
</template>

<script>
export default {
  name: "Alertdialog",
  props:['value', 'message', 'hasError'],
  computed: {
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
  border-radius: 32px;
  background: #FFF;
}
::v-deep .vue-star-rating{
  gap: 8px;
}
</style>