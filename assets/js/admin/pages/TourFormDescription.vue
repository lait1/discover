<template>
<div class="tour-form__description">
  <v-row>
    <v-col cols="12">
      <v-text-field
          label="Заголовок"
          maxlength="50"
          counter
          outlined
          required
      ></v-text-field>
      <v-textarea
          label="Полное описание"
          maxlength="300"
          counter
          outlined
          required
      ></v-textarea>
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