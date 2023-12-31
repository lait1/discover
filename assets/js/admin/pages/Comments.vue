<template>
  <v-data-table
      :headers="headers"
      :items="comments"
      sort-by="name"
      class="elevation-1 order__list"
      :loading="loading"
      loading-text="Loading... Please wait"
  >
    <template v-slot:top>
      <v-toolbar
          flat
      >
        <v-toolbar-title>Отзывы</v-toolbar-title>
        <v-divider
            class="mx-4"
            inset
            vertical
        ></v-divider>
        <v-spacer></v-spacer>
      </v-toolbar>
    </template>
    <template #item.text="{ item }">
      <div class="pa-3">{{ item.text }}</div>
    </template>
    <template v-slot:item.tour="{ item }">
      <a :href="'/tour/' + item.tour.slug" target="_blank" class="order__list-link">{{ item.tour.name }}</a>
    </template>
    <template v-slot:item.isPublic="{ item }">
      <v-simple-checkbox
          v-model="item.isPublic"
          @click="togglePublicComment(item)"
      ></v-simple-checkbox>
    </template>
    <template v-slot:item.showMainPage="{ item }">
      <v-simple-checkbox
          v-model="item.showMainPage"
          @click="togglePublicToMainComment(item)"
      ></v-simple-checkbox>
    </template>
  </v-data-table>
</template>

<script>
import axiosInstance from "../requestService";

export default {
  name: "Comments",
  data: () => ({
    loading: false,
    comments: [],
    headers: [
      { text: 'Клиент', value: 'author', align: 'start' },
      { text: 'Тур', value: 'tour' },
      { text: 'Оценка', value: 'stars' },
      { text: 'Дата', value: 'date' },
      { text: 'Коммент', value: 'text' },
      { text: 'Опубликовать', value: 'isPublic', sortable: false },
      { text: 'На главной', value: 'showMainPage', sortable: false },
    ]
  }),
  mounted() {
    this.getComments()
  },
  methods:{
    getComments(){
      this.loading = true
      axiosInstance.get(`/api/comment/get-comments`)
          .then((response) => {
            this.comments = response.data
          })
          .catch((response) => {
            alert("Ошибка загрузки комментов");
          })
          .finally(() => {
            this.loading = false
          })
    },
    togglePublicComment(item){
      if (item.isPublic) {
        axiosInstance.post(`/api/comment/publish/${item.id}`)
            .catch((response) => {
              console.error(response)
              alert("Ошибка смена статуса комментария");
            })
      } else {
        axiosInstance.post(`/api/comment/unpublish/${item.id}`)
            .catch((response) => {
              console.error(response)
              alert("Ошибка смена статуса комментария");
            })
      }
    },
    togglePublicToMainComment(item){
      if (item.showMainPage){
        axiosInstance.post(`/api/comment/publish-to-main/${item.id}`)
            .catch((response) => {
              console.error(response)
              alert("Ошибка смена статуса комментария");
            })
      }else{
        axiosInstance.post(`/api/comment/unpublish-main/${item.id}`)
            .catch((response) => {
              console.error(response)
              alert("Ошибка смена статуса комментария");
            })
      }
    },
  }
}
</script>

<style scoped lang="scss">
.order__list-link{
  text-decoration: none;
}
</style>