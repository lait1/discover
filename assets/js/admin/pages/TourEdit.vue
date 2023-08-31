<template>
  <TourForm
    :tour-id="$route.params.id"
  />

</template>

<script>
import TourForm from "./TourForm";

export default {
  name: "TourEdit",
  components: {TourForm}
}
</script>

<style scoped>

</style>