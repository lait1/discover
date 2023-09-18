<template>
  <v-app >
    <v-dialog class="order__dialog" v-model="showDialog" @click:outside="closeDialog" max-width="600px">
      <v-card class="tour-builder__dialog">
        <h1 class="tour__dialog-header">Составьте свой тур</h1>

        <v-stepper non-linear v-model="step" outlined>
          <v-stepper-header>
            <v-stepper-step step="1" :complete="step > 1" complete-icon="fa-check" class="pr-6"/>
            <v-divider></v-divider>
            <v-stepper-step step="2" :complete="step > 2" complete-icon="fa-check" class="px-6" />
            <v-divider></v-divider>
            <v-stepper-step step="3" :complete="step > 3" complete-icon="fa-check" class="pl-6"/>
          </v-stepper-header>
        </v-stepper>

        <v-window v-model="step">
          <v-window-item :value="1">
            <v-container>
              <v-row align="center" justify="start">
                <v-col
                    v-for="(selection, i) in selections"
                    :key="selection.text"
                    cols="auto"
                    class="py-1 pe-0"
                >
                  <v-chip
                      :disabled="loading"
                      close
                      close-icon="fa-circle-xmark"
                      @click:close="selected.splice(i, 1)"
                  >
                    <v-icon :icon="selection.icon" start></v-icon>

                    {{ selection.text }}
                  </v-chip>
                </v-col>

                <v-col v-if="!allSelected" cols="12">
                  <v-text-field
                      v-model="search"
                      hide-details
                      label="Поиск"
                      single-line
                  ></v-text-field>
                </v-col>
              </v-row>
            </v-container>

            <v-divider v-if="!allSelected"></v-divider>

            <v-list>
              <template v-for="item in categories">
                <v-list-item
                    v-if="!selected.includes(item)"
                    :key="item.text"
                    :disabled="loading"
                    @click="selected.push(item)"
                >
                  <template v-slot:prepend>
                    <v-icon :disabled="loading" :icon="item.icon"></v-icon>
                  </template>

                  <v-list-item-title v-text="item.text"></v-list-item-title>
                </v-list-item>
              </template>
            </v-list>
          </v-window-item>

          <v-window-item :value="2" class="tour__dialog-window">
              <div class="tour__dialog-row">
                <div class="tour__dialog-col">
                  <label for="userName" class="tour__dialog-label">Ваше имя</label>
                  <input v-model="order.name" placeholder="Имя" class="tour__dialog-input" type="text" name="userName" id="userName">
                </div>
                <div class="tour__dialog-col">
                  <label for="userPhone" class="tour__dialog-label">Номер телефона</label>
                  <phone-mask-input
                      id="userPhone"
                      v-model="order.phone"
                      autoDetectCountry
                      wrapperClass="tour__dialog-input-wrap"
                      inputClass="tour__dialog-input"
                  />
                </div>
              </div>
            <div class="tour__dialog-row">
              <div class="order__people-row">
                Количество человек:
                <div class="order__people__count-block">
                  <v-btn
                      class="order__people-btn"
                      fab
                      depressed
                      max-height="32"
                      max-width="32"
                      :disabled="isDisableDecrementPeopleCounter"
                      @click="order.countPeople--"
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
                      :disabled="isDisableIncrementPeopleCounter"
                      @click="order.countPeople++"
                  >
                    <i class="fa fa-plus"></i>
                  </v-btn>
                </div>
              </div>
              <div class="order__people-row">
                Сколько дней:
                <div class="order__people__count-block">
                  <v-btn
                      class="order__people-btn"
                      fab
                      depressed
                      max-height="32"
                      max-width="32"
                      :disabled="isDisableDecrementDayCounter"
                      @click="order.countDay--"
                  >
                    <i class="fa fa-minus"></i>
                  </v-btn>
                  <span class="order__people-counter">{{ this.order.countDay }}</span>
                  <v-btn
                      class="order__people-btn"
                      fab
                      depressed
                      max-height="32"
                      max-width="32"
                      :disabled="isDisableIncrementDayCounter"
                      @click="order.countDay++"
                  >
                    <i class="fa fa-plus"></i>
                  </v-btn>
                </div>
              </div>
            </div>
          </v-window-item>

          <v-window-item :value="3">
            <div class="tour__dialog-row">
              <div class="tour__dialog-col">
                <label for="textComment" class="tour__dialog-label order__description">Коментарий <span>(не обязательно)</span></label>
                <textarea
                    v-model="order.text"
                    placeholder="Напишите здесь ваши пожелания или вопросы"
                    class="tour__dialog-input tour__dialog-input-textarea"
                    name="textComment"
                    id="textComment"></textarea>
              </div>
            </div>
          </v-window-item>
        </v-window>

        <v-card-actions>
          <button
              class="tour__dialog-button tour__dialog-button-back"
              :class="{ 'tour__dialog-button-disabled':  step === 1 }"
              @click="step--">Назад</button>
          <v-spacer></v-spacer>

          <button v-if="step === 3" class="tour__dialog-button" @click="sendOrder" >
            Заказать
          </button>

          <button v-else class="tour__dialog-button" @click="step++" >
            Далее
          </button>

        </v-card-actions>
      </v-card>
    </v-dialog>
  </v-app>
</template>

<script>
import axios from "axios";
import PhoneMaskInput from  "vue-phone-mask-input";
import {FunctionalCalendar} from "vue-functional-calendar";

export default {
  name: "OrderDialog",
  components: {
    PhoneMaskInput, FunctionalCalendar
  },
  props:['value'],
  data: function () {
    return {
      order:{
        name: '',
        countPeople: 1,
        countDay: 1,
        selectedCategories: [],
        phone: '',
        text: '',
      },
      categoryList: [],
      loading: false,
      search: '',
      selected: [],
      errors: [],
      step: 1,
    }
  },
  mounted() {
    this.getCategories()
  },
  computed: {
    showDialog() {
      return this.value
    },
    allSelected() {
      return this.selected.length === this.categoryList.length
    },
    categories() {
      const search = this.search.toLowerCase()

      if (!search) return this.categoryList

      return this.categoryList.filter(item => {
        const text = item.text.toLowerCase()

        return text.indexOf(search) > -1
      })
    },
    isDisableIncrementPeopleCounter(){
      return this.order.countPeople >= 12
    },
    isDisableDecrementPeopleCounter(){
      return this.order.countPeople <= 1
    },
    isDisableIncrementDayCounter(){
      return this.order.countDay >= 14
    },
    isDisableDecrementDayCounter(){
      return this.order.countDay <= 1
    },
    selections() {
      const selections = []

      for (const selection of this.selected) {
        selections.push(selection)
      }

      return selections
    },
  },
  watch: {
    showDialog() {
      return this.value
    },
    selected() {
      this.search = ''
    },
  },

  methods: {
    getCategories(){
      axios.get(`/order/get-categories`)
          .then((response) => {
            this.categoryList = response.data
          })
          .catch((response) => {
            console.error(response)
          })
    },
    closeDialog() {
      this.$emit('closeDialog');
    },
    clearForm() {
      this.order.name = ''
      this.order.phone = ''
      this.order.text = ''
    },
    validation() {
      this.errors = []

      if (this.order.phone.slice(0, 4) === '+995' && this.order.phone.length < 13) {
        this.errors.push('Длина номера телефона маловато будет')
      }
      if (this.order.phone.slice(0, 2) === '+7' && this.order.phone.length < 12) {
        this.errors.push('Длина номера телефона маловато будет')
      }
      if (this.order.name.length < 3) {
        this.errors.push('Длина имени маловато будет')
      }
      return this.errors.length === 0
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
      this.order.selectedCategories = this.selections

      axios.post('/order/make-my-tour', this.order)
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
::v-deep .v-dialog{
  max-height: 100%;
}
::v-deep .theme--light.v-btn.v-btn--has-bg{
  background-color: #E5EFFF;
  color: #0062FB;
}
::v-deep .v-card {
  display: flex;
  padding: 32px;
  flex-direction: column;
}
::v-deep .v-dialog > .v-card > .v-card__actions{
  padding: 24px 0 0 0;
  justify-content: space-between;
  display: flex;
}
::v-deep .v-stepper{
  border: none;
  &__step{
    padding: 0;
    &--active{
      span{
        font-size: 16px;
        font-style: normal;
        font-weight: 600;
        line-height: 24px;
        width: 32px;
        height: 32px;
        color: #0062FB !important;
        background-color: #E5EFFF !important;
      }
    }
  }

}
::v-deep .v-sheet.v-list{
  max-height: 280px;
  overflow: auto;
}
::v-deep .v-application--wrap {
  min-height: fit-content;
}
::v-deep .v-dialog{
  border-radius: 32px;
  background: #FFF;
}
</style>