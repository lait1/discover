<template>
  <v-app id="inspire">
    <v-container class="grey lighten-5">
      <v-row
          class='mb-6'
          no-gutters
      >
        <v-col cols="6" class="pr-4 tour-form__example">
          <img src="/build/images/example.png" alt="example">
        </v-col>
        <v-col cols="6" >
          <form>
            <v-text-field
                v-model="tour.name"
                label="Наименование тура"
                outlined
                required
            ></v-text-field>
            <v-text-field
                v-model="tour.title"
                label="Краткое описание"
                outlined
                required
            ></v-text-field>
            <v-textarea
                v-model="tour.description"
                label="Полное описание"
                outlined
                required
            ></v-textarea>
            <v-select
                v-model="tour.complexity"
                :items="complexity"
                label="Сложность"
                outlined
                required
            ></v-select>
            <v-checkbox
                v-model="tour.public"
                label="Показать на сайте"
                required
            ></v-checkbox>

            <v-btn
                class="mr-4"
                color="success"
                @click="submit"
            >
              Сохранить
            </v-btn>
            <v-btn @click="clear">
              Назад
            </v-btn>
          </form>
        </v-col>
      </v-row>
    </v-container>
    
  </v-app>
</template>

<script>
export default {
  name: "TourForm",
  props:['tourId'],
  data: () => ({
    tour: {
      name: '',
      title: '',
      description: '',
      price: 100,
      longTime: '',
      complexity: 'easy',
      groupSize: 1,
      keyWords: '',
      public: false,
      photos: [],
      tourDescriptions: []
    },
    complexity: [
      'hard',
      'medium',
      'easy',
    ],
    categories: [],
  }),
  created() {

  },
  methods: {
    submit () {

    },
    getCategories(){

    },
    clear () {
      this.name = ''
      this.email = ''
      this.select = null
      this.checkbox = false
    },
  },
}
</script>

<style scoped lang="scss">
.tour-form{
  &__example{
    img{
      width: 100%;
    }
  }
}
</style>