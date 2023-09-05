<template>
  <form action="">
    <h3 class="tour-form__header">Настройки:</h3>
    <v-text-field
        v-model="tour.keyWords"
        label="Мета теги"
        maxlength="50"
        counter
        outlined
        required
    ></v-text-field>
    <v-text-field
        v-model="tour.price"
        label="Цена"
        type="number"
        value="100"
        prefix="GEL"
    ></v-text-field>
    <v-checkbox
        v-model="tour.public"
        label="Показать на сайте"
        required
    ></v-checkbox>
  </form>
</template>

<script>
export default {
  name: "TourFormSettings"
}
</script>

<style scoped>

</style>