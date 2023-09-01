<template>
<div class="tour-form__description">
  <v-row>
    <v-col>
      <v-textarea
          label="Полное описание"
          maxlength="300"
          counter
          outlined
          required
      ></v-textarea>
    </v-col>
    <v-col>
      <v-file-input
          small-chips
          multiple
          show-size
          accept="image/png, image/jpeg, image/jpg"
          label="Фото описания"
      ></v-file-input>
    </v-col>
  </v-row>

</div>
</template>

<script>
export default {
  name: "TourFormDescription"
}
</script>

<style scoped>

</style>