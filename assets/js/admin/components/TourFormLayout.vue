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
import axiosInstance from "../requestService";
import draggable from 'vuedraggable'
import TourFormPhotos from "./TourFormPhotos";
import TourFormMainPhoto from "./TourFormMainPhoto";
import TourFormDescription from "./TourFormDescription";

export default {
  name: "TourFormLayout",
  components: {
    draggable, TourFormPhotos, TourFormMainPhoto, TourFormDescription
  },
  props:['exampleImage'],
  data: function () {
    return {
      tour: {
        id: this.tourId,
        name: '',
        mainPhoto: '',
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