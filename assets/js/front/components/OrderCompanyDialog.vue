<template>
  <v-app>
    <v-dialog
        attach=".order__banner"
        v-model="showOrderDialog"
        :fullscreen="fullscreen"
        max-width="600px"
        @click:outside="closeDialog"
    >
      <v-card class="tour__dialog">
        <h1 class="tour__dialog-header">Заказать тур</h1>
        <button class="dialog__close" @click="closeDialog">
          <svg class="icon">
            <use xlink:href="#close"></use>
          </svg>
        </button>
        <div class="wrap">
          <div class="tour__dialog-row">
            <div class="tour__dialog-col">
              <label for="userName" class="tour__dialog-label">Ваше имя</label>
              <input
                  v-model="order.name"
                  placeholder="Имя"
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
                  v-model="order.phone"
                  autoDetectCountry
                  wrapperClass="tour__dialog-input-wrap"
                  :inputClass="hasPhoneError ? 'tour__dialog-input error__active' : 'tour__dialog-input'"
              />
              <span v-if="hasPhoneError" class="error__message">{{ phoneError.join(',') }}</span>
            </div>
          </div>
          <div class="order__people-row">
              Количество человек:
            <div class="order__people__count-block">
              <v-btn
                  class="order__people-btn"
                  fab
                  depressed
                  max-height="32"
                  max-width="32"
                  :disabled="isDisableDecrementCounter"
                  @click="decrementCountPeople"
              >
                <i class="fa fa-minus"></i>
              </v-btn>
              <span class="order__people-counter">{{ this.order.countPeople }}</span>
              <v-btn
                  class="order__people-btn"
                  fab
                  depressed
                  max-height="32"
                  max-width="32"
                  :disabled="isDisableIncrementCounter"
                  @click="incrementCountPeople"
              >
                <i class="fa fa-plus"></i>
              </v-btn>
            </div>
          </div>
          <div class="tour__dialog-row">
            <div class="tour__dialog-col">
              <label for="textComment" class="tour__dialog-label order__description">Комментарий <span>(не обязательно)</span></label>
              <textarea v-model="order.text" placeholder="Напишите здесь ваши пожелания или вопросы" class="tour__dialog-input" name="textComment"
                        id="textComment"></textarea>
            </div>
          </div>
          <div class="tour__dialog-row">
            <div class="tour__dialog-col">
              <button class="tour__dialog-button" @click="sendOrder" >
                Заказать
              </button>
            </div>
          </div>
        </div>
      </v-card>
    </v-dialog>
  </v-app>
</template>

<script>
import axios from "axios";
import PhoneMaskInput from  "vue-phone-mask-input";
export default {
  name: "OrderCompanyDialog",
  components: {
    PhoneMaskInput
  },
  props:['value', 'tripId', 'selectedDate', 'price', 'disableDate'],
  data: function () {
    return {
      order:{
        name: '',
        countPeople: 1,
        phone: '',
        text: '',
      },
      phoneError: [],
      nameError: []
    }
  },
  computed: {
    fullscreen() {
      return this.$vuetify.breakpoint.width <= 586;
    },
    showOrderDialog() {
      return this.value
    },
    isDisableIncrementCounter(){
      return this.order.countPeople >= 100
    },
    isDisableDecrementCounter(){
      return this.order.countPeople <= 1
    },
    hasPhoneError(){
      return this.phoneError.length > 0
    },
    hasNameError(){
      return this.nameError.length > 0
    }
  },
  methods: {
    incrementCountPeople(){
      this.order.countPeople++
    },
    decrementCountPeople(){
      this.order.countPeople--
    },
    closeDialog() {
      this.$emit('closeDialog');
    },
    choseDate(date) {
      this.order.date = date.date
    },
    clearForm() {
      this.order.name = ''
      this.order.date = ''
      this.order.text = ''
    },
    validation() {
      this.phoneError = []
      this.nameError = []

      if (this.order.phone.slice(0, 4) === '+995' && this.order.phone.length < 13) {
        this.phoneError.push('Длина номера телефона маловато будет')
      }
      if (this.order.phone.slice(0, 2) === '+7' && this.order.phone.length < 12) {
        this.phoneError.push('Длина номера телефона маловато будет')
      }
      if (this.order.name.length < 3) {
        this.nameError.push('Длина имени маловато будет')
      }
      return this.nameError.length === 0 && this.phoneError.length === 0
    },
    successRequest() {
      this.$emit('showSuccessMessage', 'Мы очень скоро с Вами свяжемся!');
    },
    errorRequest(error) {
      this.$emit('showErrorMessage', error);
    },
    sendOrder(){
      if (! this.validation()){
        return
      }

      axios.post('/order/book-corporate', this.order)
          .then((response) => {
            if (response.data.message === 'success'){
              this.successRequest()
              this.clearForm()
            }
          })
          .catch((error) => {
            if (error.response.status === 400){
              this.errorRequest(error.response.data.error)
              return
            }

            this.errorRequest('У нас технические трудности, попробуйте позднее')
          });
    },
  },
};
</script>

<style scoped lang="scss">
::v-deep .vfc-single-input{
  text-align: left;
}
::v-deep .v-dialog{
  max-height: 100%;
}
::v-deep .theme--light.v-btn.v-btn--has-bg{
  background-color: #E5EFFF;
  color: #0062FB;
}
::v-deep .vfc-single-input{
  border: none;
}
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