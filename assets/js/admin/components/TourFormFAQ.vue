<template>
<div class="tour-form__description">
  <v-row v-for="faq in tour.faqList" :key="faq.id" >
    <v-col cols="12">
      <v-text-field
          label="Заголовок"
          v-model="faq.header"
          maxlength="50"
          counter
          outlined
          required
      ></v-text-field>
      <v-textarea
          label="Описание"
          v-model="faq.content"
          maxlength="550"
          counter
          outlined
          required
      ></v-textarea>
    </v-col>
  </v-row>

  <v-btn
      class="mr-4"
      color="success"
      @click="updateInfo"
  >
    Сохранить
  </v-btn>

</div>
</template>

<script>
import axiosInstance from "../requestService";

export default {
  name: "TourFormFAQ",
  props: ['tourId', 'tourFaqList'],
  data: function () {
    return {
      tour: {
        id: this.tourId,
        faqList: [
          {
            header: '',
            content: ''
          }
        ],
      },
    }
  },
  methods: {
    updateInfo(){
      axiosInstance.post(`/api/tour/update-desc-info`, this.tour)
          .then((response) => {
            if (response.data.message === 'success'){
              alert("Данные успешно обновлены");
            }
          })
          .catch((response) => {
            console.error(response)
            alert("Save tour failed");
          })
    }
  }
}
</script>

<style scoped lang="scss">
.tour-form {
  &__photo {
    display: flex;
    flex-direction: row;
    flex-wrap: wrap;

    &-thumbnail {
      margin: 5px;
      position: relative;
    }

    &:hover img {
      filter: brightness(40%);
    }

    &:hover button {
      display: block;
    }

    img {
      width: 100%;
      height: 100%;
      transition: .3s ease-in-out;
    }

    button {
      position: absolute;
      right: 5px;
      top: 5px;
      color: #fff;
      background: transparent;
      border: none;
      font-size: 20px;
      display: none;
    }
  }
}
</style>