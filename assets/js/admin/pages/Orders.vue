<template>
  <v-data-table
      :headers="headers"
      :items="orders"
      sort-by="name"
      class="elevation-1 order__list"
      :loading="loading"
      loading-text="Loading... Please wait"
  >
    <template v-slot:top>
      <v-toolbar
          flat
      >
        <v-toolbar-title>Список заказов</v-toolbar-title>
        <v-divider
            class="mx-4"
            inset
            vertical
        ></v-divider>
        <v-spacer></v-spacer>
      </v-toolbar>
    </template>
    <template v-slot:item.client="{ item }">
      <span>{{ item.client.name }}</span>
      (<a :href="'tel:' + item.client.phone" class="order__list-link">{{ item.client.phone }}</a>)
    </template>
    <template v-slot:item.tour="{ item }">
      <a :href="'/tour/' + item.tour.slug" target="_blank" class="order__list-link">{{ item.tour.name }}</a>
    </template>
    <template v-slot:item.actions="{ item }">
      <v-chip
          class="ma-2"
          color="green"
          text-color="white"
          link
          @click="approve(item)"
      >
        <v-avatar left>
          <v-icon>mdi-checkbox-marked-circle</v-icon>
        </v-avatar>
        Принять
      </v-chip>
      <v-chip
          class="ma-2"
          color="red"
          text-color="white"
          link
          @click="reject(item)"
      >
        <v-avatar left>
          <v-icon>mdi-cancel</v-icon>
        </v-avatar>
        Отклонить
      </v-chip>
    </template>
  </v-data-table>
</template>

<script>
import axiosInstance from "../requestService";

export default {
  name: "Orders",
  data: () => ({
    loading: false,
    orders: [],
    headers: [
      { text: 'Клиент', value: 'client', align: 'start' },
      { text: 'Тур', value: 'tour' },
      { text: 'Статус', value: 'status' },
      { text: 'Дата бронирования', value: 'dateReservation' },
      { text: 'Число людей', value: 'countPeople' },
      { text: 'Коммент', value: 'comment' },
      { text: 'Actions', value: 'actions', sortable: false },]
  }),
  mounted() {
    this.getOrders()
  },
  methods:{
    getOrders(){
      this.loading = true
      axiosInstance.get(`/api/order/get-orders/`)
          .then((response) => {
            this.orders = response.data
          })
          .catch((response) => {
            alert("Ошибка загрузки заказов");
          })
          .finally(() => {
            this.loading = false
          })
    },
    approve(item){
      alert("Заявка подтверждена, время забронировано");
    },
    reject(item){
      alert("Заявка отклонена");
    }
  }
}
</script>

<style scoped lang="scss">
.order__list-link{
    text-decoration: none;
}
</style>