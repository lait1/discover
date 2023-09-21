<template>
  <v-app class="comment__dialog">
    <v-dialog
        attach=".comment__dialog"
        v-model="showCommentDialog"
        max-width="600px"
        :fullscreen="fullscreen"
        @click:outside="closeDialog"
    >
      <v-card class="tour__dialog">
        <h1 class="tour__dialog-header">Добавить отзыв</h1>
        <button class="dialog__close" @click="closeDialog">
          <svg class="icon">
            <use xlink:href="#close"></use>
          </svg>
        </button>
        <div class="wrap">
          <div class="tour__dialog-col">
            <label class="tour__dialog-label">Поставьте оценку</label>
            <StarRating v-model="review.rating" :star-size="40" :show-rating="false"/>
          </div>
          <div class="tour__dialog-row">
            <div class="tour__dialog-col">
              <label for="userName" class="tour__dialog-label">Ваше имя</label>
              <input
                  v-model="review.name"
                  class="tour__dialog-input"
                  type="text"
                  name="userName"
                  id="userName"
                  :class="hasNameError ? 'error__active' : null"
              >
              <span v-if="hasNameError" class="error__message">{{ nameError.join(',') }}</span>
            </div>
            <div class="tour__dialog-col">
              <label for="userPhone" class="tour__dialog-label">Номер телефона</label>
              <phone-mask-input
                  id="userPhone"
                  v-model="review.phone"
                  autoDetectCountry
                  wrapperClass="tour__dialog-input-wrap"
                  :inputClass="hasPhoneError ? 'tour__dialog-input error__active' : 'tour__dialog-input'"
              />
              <span v-if="hasPhoneError" class="error__message">{{ phoneError.join(',') }}</span>
            </div>
          </div>
          <div class="tour__dialog-row">
            <div class="tour__dialog-col">
              <label for="textComment" class="tour__dialog-label">Отзыв</label>
              <textarea v-model="review.text" class="tour__dialog-input" name="textComment"
                        id="textComment"></textarea>
            </div>
          </div>
          <div class="tour__dialog-row">
            <div class="tour__dialog-col">
              <label for="textComment" class="tour__dialog-label">Добавить фото</label>
              <drag-and-drop @file-dropped="loadPhoto" />
            </div>
          </div>
          <button class="tour__dialog-button" @click="addComment" >
            Отправить
          </button>
        </div>
      </v-card>
    </v-dialog>
  </v-app>
</template>

<script>
import StarRating from 'vue-star-rating'
import axios from "axios";
import PhoneMaskInput from  "vue-phone-mask-input";
import DragAndDrop from "./DragAndDrop";

export default {
  name: "Commentdialog",
  components: {
    StarRating, PhoneMaskInput, DragAndDrop
  },
  props:['value', 'tripId'],
  data: function () {
    return {
      review:{
        tourId: this.tripId,
        rating: 5,
        name: '',
        phone: '',
        text: '',
      },
      selectedImages: [],
      phoneError: [],
      nameError: []
    }
  },
  computed: {
    showCommentDialog() {
      return this.value
    },
    fullscreen() {
      return this.$vuetify.breakpoint.width <= 586;
    },
    hasPhoneError(){
      return this.phoneError.length > 0
    },
    hasNameError(){
      return this.nameError.length > 0
    }
  },
  methods: {
    closeDialog() {
      this.$emit('closeDialog');
    },
    clearForm() {
      this.review.name = ''
      this.review.phone = ''
      this.review.rating = 5
      this.review.text = ''
    },
    successComment() {
      this.$emit('showSuccessMessage', 'Спасибо! Совсем скоро ваш отзыв будет опубликован');
    },
    errorComment(error) {
      console.log(error)
      this.$emit('showErrorMessage', error);
    },
    loadPhoto(files){
      this.selectedImages = files
    },
    validation() {
      this.phoneError = []
      this.nameError = []

      if (this.review.phone.slice(0, 4) === '+995' && this.review.phone.length < 13) {
        this.phoneError.push('Длина номера телефона маловато будет')
      }
      if (this.review.phone.slice(0, 2) === '+7' && this.review.phone.length < 12) {
        this.phoneError.push('Длина номера телефона маловато будет')
      }
      if (this.review.name.length < 3) {
        this.nameError.push('Длина имени маловато будет')
      }
      return this.nameError.length === 0 && this.phoneError.length === 0
    },
    addComment(){
      this.selectedImages = [];
      if (! this.validation()){
        return
      }
      let data = new FormData()
      data.append('tourId', this.review.tourId)
      data.append('name', this.review.name)
      data.append('phone', this.review.phone)
      data.append('rating', this.review.rating)
      data.append('text', this.review.text)

      for (let i = 0; i < this.selectedImages.length; i++) {
        data.append(i, this.selectedImages[i]);
      }
      axios.post('/comment/add', data)
          .then((response) => {
            if (response.data.message === 'success'){
              this.successComment()
              this.clearForm()
            }
          })
          .catch((error) => {
            if (error.response.status === 400){
              this.errorComment(error.response.data.error)
              return
            }

            this.errorComment('У нас технические трудности, попробуйте позднее')
          });
    },
  },
};
</script>

<style scoped lang="scss">
::v-deep .v-card {
  display: flex;
  padding: 32px;
  flex-direction: column;
  @media screen and (max-width: 568px) {
    padding: 24px !important;
  }
}
::v-deep .v-application--wrap {
  min-height: fit-content;
}
::v-deep .v-dialog{
  border-radius: 32px;
  background: #FFF;
  @media screen and (max-width: 568px) {
    border-radius: 0;
  }
}
::v-deep .vue-star-rating{
  gap: 8px;
}
::v-deep .error {
  &__active {
    border: 2px solid #fd5f5f;
  }

  &__message {
    color: #fd5f5f;
    font-size: 14px;
  }
}
</style>