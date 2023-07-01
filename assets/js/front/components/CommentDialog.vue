<template>
  <v-app >
    <v-dialog v-model="showPopup" @click:outside="closeDialog" max-width="600px">
      <v-card>

          <h1>Добавить отзыв</h1>
        <label for="userName">Name?</label>
        <input v-model="review.name" class="tour__comment-input"  type="text" name="userName" id="userName">
        <br>
        <StarRating v-model="review.rating" :show-rating="false" />
        <br>
        <label for="userPhone">Phone</label>
        <input v-model="review.phone" class="tour__comment-input"  type="text" name="userPhone" id="userPhone">
        <br>
        <label for="textComment">Text</label>
        <textarea v-model="review.text"  class="tour__comment-input" name="textComment" id="textComment"> </textarea>
        <br>


        <button @click="addComment" >
          Отправить
        </button>
      </v-card>
    </v-dialog>
  </v-app>
</template>

<script>
import StarRating from 'vue-star-rating'
import axios from "axios";

export default {
  name: "Commentdialog",
  components: {
    StarRating
  },
  props:['value'],
  data: () => ({
    review:{
      tourId: 1233,
      rating: 5,
      name: '',
      phone: '',
      text: '',
    }
  }),
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
.tour__comment{
  &-input{
    padding: 12px 16px;
    border-radius: 16px;
    background: var(--background-primary, #F6F6FA);
  }
}

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
</style>