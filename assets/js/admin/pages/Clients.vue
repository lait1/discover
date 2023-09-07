<template>
  <v-data-table
      :headers="headers"
      :items="clients"
      sort-by="name"
      class="elevation-1 order__list"
      :loading="loading"
      loading-text="Loading... Please wait"
  >
    <template v-slot:top>
      <v-toolbar
          flat
      >
        <v-toolbar-title>Список клиентов</v-toolbar-title>
        <v-divider
            class="mx-4"
            inset
            vertical
        ></v-divider>
        <v-spacer></v-spacer>
      </v-toolbar>
    </template>
    <template v-slot:item.phone="{ item }">
      <a :href="'tel:' + item.phone" class="order__list-link">{{ item.phone }}</a>
    </template>
    <template v-slot:item.tour="{ item }">
      <a :href="'/tour/' + item.tour.slug" target="_blank" class="order__list-link">{{ item.tour.name }}</a>
    </template>
  </v-data-table>
</template>

<script>
import axiosInstance from "../requestService";

export default {
  name: "Clients",
  data: () => ({
    loading: false,
    clients: [],
    headers: [
      { text: 'Имя', value: 'name', align: 'start' },
      { text: 'Телефон', value: 'phone' },
      { text: 'Дата', value: 'date' },
    ]
  }),
  mounted() {
    this.getClients()
  },
  methods:{
    getClients(){
      this.loading = true
      axiosInstance.get(`/api/client/get-clients/`)
          .then((response) => {
            this.clients = response.data
          })
          .catch((response) => {
            alert("Ошибка загрузки списка клиентов");
          })
          .finally(() => {
            this.loading = false
          })
    },
  }
}
</script>

<style scoped lang="scss">
.order__list-link{
  text-decoration: none;
}
</style>