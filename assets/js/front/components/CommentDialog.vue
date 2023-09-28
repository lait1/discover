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
              <textarea
                  v-model="review.text"
                  class="tour__dialog-input"
                  name="textComment"
                  id="textComment"
                  :class="hasTextError ? 'error__active' : null"
              >
              </textarea>
              <span v-if="hasTextError" class="error__message">{{ textError.join(',') }}</span>
            </div>
          </div>
          <div class="tour__dialog-row">
            <div class="tour__dialog-col">
              <label for="textComment" class="tour__dialog-label">Добавить фото</label>
              <drag-and-drop
                  :selected-images="selectedImages"
                  @remove-file="removePhoto"
                  @file-dropped="loadPhoto"
              />
              <span  class="info__message">Не более 6 фотографий. Допустимые форматы jpeg, png</span>
            </div>
          </div>
          <button
              class="tour__dialog-button"
              @click="addComment"
              :disabled="sendingRequest"
              :class="sendingRequest ? 'tour__dialog-button-disabled' : null"
          >
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
      images: [],
      phoneError: [],
      nameError: [],
      textError: [],
      sendingRequest: false
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
    },
    hasTextError(){
      return this.textError.length > 0
    }
  },
  methods: {
    closeDialog() {
      this.$emit('closeDialog');
      this.clearForm()
    },
    clearForm() {
      this.review.name = ''
      this.review.rating = 5
      this.review.text = ''
      this.phoneError = []
      this.nameError = []
      this.textError = []
      this.selectedImages = []
      this.images = []
    },
    removePhoto(index){
      this.selectedImages.splice(index, 1)
      let imagesArray = Array.from(this.images);
      imagesArray.splice(index, 1)
      this.images = imagesArray
    },
    successComment() {
      this.$emit('showSuccessMessage', 'Спасибо! Совсем скоро ваш отзыв будет опубликован');
    },
    errorComment(error) {
      console.log(error)
      this.$emit('showErrorMessage', error);
    },
    loadPhoto(files){
      this.images = files
      for (let i = 0; i < files.length; i++) {
        const file = files[i];
        const reader = new FileReader();

        reader.onload = (e) => {
          this.selectedImages.push(e.target.result);
        };

        reader.readAsDataURL(file);
      }
    },
    validation() {
      this.phoneError = []
      this.nameError = []
      this.textError = []

      if (this.review.phone.slice(0, 4) === '+995' && this.review.phone.length < 13) {
        this.phoneError.push('Длина номера телефона маловато будет')
      }
      if (this.review.phone.slice(0, 2) === '+7' && this.review.phone.length < 12) {
        this.phoneError.push('Длина номера телефона маловато будет')
      }
      if (this.review.name.length < 3) {
        this.nameError.push('Длина имени маловато будет')
      }
      if (this.review.text.length < 10) {
        this.textError.push('Сообщение маленькое, давайте постараемся')
      }
      return this.nameError.length === 0 && this.phoneError.length === 0 && this.textError.length === 0
    },
    addComment(){
      if (! this.validation()){
        return
      }
      this.sendingRequest = true
      let data = new FormData()
      data.append('tourId', this.review.tourId)
      data.append('name', this.review.name)
      data.append('phone', this.review.phone)
      data.append('rating', this.review.rating)
      data.append('text', this.review.text)

      for (let i = 0; i < this.images.length; i++) {
        data.append(i, this.images[i]);
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
          })
          .finally(() => {
            this.sendingRequest = false
          })
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
.info {
  &__message {
    color: #918f8f;
    font-size: 14px;
  }
}
</style>