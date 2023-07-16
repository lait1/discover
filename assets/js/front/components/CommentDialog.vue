<template>
  <v-app >
    <v-dialog v-model="showPopup" @click:outside="closeDialog" max-width="600px">
      <v-card class="comment__dialog">
        <h1 class="comment__dialog-header">Добавить отзыв</h1>
        <div class="wrap">
          <div class="comment__dialog-col">
            <label class="comment__dialog-label">Поставьте оценку</label>
            <StarRating v-model="review.rating" :star-size="40" :show-rating="false"/>
          </div>
          <div class="comment__dialog-row">
            <div class="comment__dialog-col">
              <label for="userName" class="comment__dialog-label">Ваше имя</label>
              <input v-model="review.name" class="comment__dialog-input" type="text" name="userName" id="userName">
            </div>
            <div class="comment__dialog-col">
              <label for="userPhone" class="comment__dialog-label">Номер телефона</label>
<!--              <input v-model="review.phone" class="comment__dialog-input" type="text" name="userPhone" id="userPhone">-->
              <phone-mask-input
                  id="userPhone"
                  v-model="review.phone"
                  autoDetectCountry
                  wrapperClass="comment__dialog-input-wrap"
                  inputClass="comment__dialog-input"
              />
            </div>
          </div>
          <div class="comment__dialog-row">
            <div class="comment__dialog-col">
              <label for="textComment" class="comment__dialog-label">Отзыв</label>
              <textarea v-model="review.text" class="comment__dialog-input" name="textComment"
                        id="textComment"></textarea>
            </div>
          </div>
          <button class="comment__dialog-button" @click="addComment" >
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
import { VueTelInput } from 'vue-tel-input';
import 'vue-tel-input/dist/vue-tel-input.css';
import PhoneMaskInput from  "vue-phone-mask-input";
export default {
  name: "Commentdialog",
  components: {
    StarRating, VueTelInput, PhoneMaskInput
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
      preferredCountries: ['ge', 'ru'],
    }
  },
  computed: {
    showPopup: {
      get () {
        return this.value
      },
      set (value) {
        this.$emit('input', value)
      }
    }
  },
  methods: {
    addComment(){
      axios.post('/comment/add', this.review)
          .then((response) => {
              console.log(response.data)
          })
          .catch((response) => {
            alert("Ошибка");
          });
    },
    closeDialog() {
      this.$emit('closeDialog');
    },
  },
};
</script>

<style scoped lang="scss">
::v-deep .v-card {
  display: flex;
  padding: 32px;
  flex-direction: column;
}
::v-deep .v-application--wrap {
  min-height: fit-content;
}
::v-deep .v-dialog{
  border-radius: 32px;
  background: #FFF;
}
::v-deep .vue-star-rating{
  gap: 8px;
}
</style>