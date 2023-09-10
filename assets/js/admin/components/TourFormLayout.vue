<template>
  <v-app id="inspire">
    <v-container class="grey lighten-5">
      <v-row
          class='mb-6'
          no-gutters
      >
        <v-col cols="6" class="pr-4 tour-form__example">
          <img :src="'/build/images/admin/' + exampleImage" alt="example">
        </v-col>
        <v-col cols="6" >
          <slot name="content"></slot>
        </v-col>
      </v-row>
    </v-container>
    
  </v-app>
</template>

<script>
export default {
  name: "TourFormLayout",
  props:['exampleImage'],
}
</script>

<style scoped lang="scss">
.tour-form{
  &__example{
    img{
      width: 100%;
    }
  }
  &__header{
    margin-bottom: 30px;
  }
}
</style>