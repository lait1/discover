<template>
  <form>
    <h3 class="tour-form__header">Куда мы едем:</h3>
    <v-row>
      <v-col cols="4">
        <v-text-field
            v-model="tour.longTime"
            label="Длина тура"
            maxlength="20"
            counter
            outlined
            required
        ></v-text-field>
      </v-col>
      <v-col cols="4">
        <v-select
            v-model="tour.complexity"
            :items="complexity"
            label="Сложность"
            outlined
            required
        ></v-select>
      </v-col>
      <v-col cols="4">
        <v-text-field
            v-model="tour.groupSize"
            label="Размер группы"
            type="number"
            outlined
            value="1"
        ></v-text-field>
      </v-col>
    </v-row>
    <v-textarea
        v-model="tour.description"
        label="Полное описание"
        maxlength="300"
        counter
        outlined
        required
    ></v-textarea>

    <TourFormPhotos
        :tour-id="tour.id"
        :images-data="imagesData"
    />
  </form>
</template>

<script>
export default {
  name: "TourFormWhereToGo"
}
</script>

<style scoped>

</style>