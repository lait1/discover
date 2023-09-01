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
            <h3 class="tour-form__header">Банер тура</h3>
            <v-text-field
                v-model="tour.name"
                label="Наименование тура"
                maxlength="50"
                outlined
                counter
                required
            ></v-text-field>
            <v-text-field
                v-model="tour.title"
                label="Краткое описание"
                maxlength="50"
                counter
                outlined
                required
            ></v-text-field>
            <v-select
                v-model="tour.categories"
                :items="categories"
                chips
                label="Категории"
                multiple
                outlined
            ></v-select>

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

            <h3 class="tour-form__header">Что вас ожидает:</h3>

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
import axiosInstance from "../requestService";
import draggable from 'vuedraggable'
import TourFormPhotos from "./TourFormPhotos";

export default {
  name: "TourForm",
  components: {
    draggable, TourFormPhotos
  },
  props:['tourId'],
  data: function () {
    return {
      tour: {
        id: this.tourId,
        name: '',
        title: '',
        description: '',
        price: 100,
        longTime: '10 часов',
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
      imagesData: [],
      categories: [],
    }
  },
  mounted() {
    this.getCategories()
  },
  methods: {
    submit () {

    },
    getCategories(){
      axiosInstance.get(`/api/get-categories/`)
          .then((response) => {
            this.categories = response.data
          })
          .catch((response) => {
            console.error(response)
            alert("Ошибка загрузки категорий");
          })
    },
    previewImages(event) {
      let data = new FormData();
      let pictures = event.target.files;
      pictures.forEach((key, value) => {
        data.append(key, value);
      });
      this.createPhoto(data);
    },
    createPhoto(files) {
      axiosInstance.post(`/api/tour/upload-photo/${this.tour.id}/`, files)
          .then((response) => {
            response.data.forEach(item => {
              this.imagesData.push(item);
            });
          })
          .catch((response) => {
            console.error(response)
            alert("Ошибка загрузки фотографий");
          });
    },
    removePhoto(id, index) {
      axios.delete(`/api/auto/photo/${id}`)
          .then((response) => {
            console.log('delete photo');
            this.imagesData.splice(index, 1);
          })
          .catch((response) => {
            alert("Ошибка");
          });
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
  &__header{
    margin-bottom: 30px;
  }
}
</style>