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
    <template v-slot:item.status="{ item }">
      <v-chip :color="colorByStatus(item.status)" outlined small> {{ item.status }} </v-chip>
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
          :disabled="item.status !== 'WAIT'"
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
          :disabled="item.status === 'REJECT'"
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
      { text: 'Actions', value: 'actions', sortable: false },
    ]
  }),
  mounted() {
    this.getOrders()
  },
  methods:{
    colorByStatus(status){
      if(status === 'APPROVE'){
        return 'green'
      }
      if(status === 'REJECT'){
        return 'red'
      }
      return 'primary'
    },
    getOrders(){
      this.loading = true
      axiosInstance.get(`/api/order/get-orders`)
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
      axiosInstance.post(`/api/order/approve`, item)
          .then((response) => {
            if (response.data.message === 'success'){
              let order = this.orders.find(({ id }) => id === item.id)
              order.status = 'APPROVE'
            }
          })
          .catch((response) => {
            if (response.response.status === 400){
              alert(response.response.data.error);
              return
            }
            alert("Ошибка апрува заказа");
          })
          .finally(() => {
            this.loading = false
          })
    },
    reject(item){
      axiosInstance.post(`/api/order/reject`, item)
          .then((response) => {
            let order = this.orders.find(({ id }) => id === item.id)
            order.status = 'REJECT'
          })
          .catch((response) => {
            alert("Ошибка реджекта заказа");
          })
          .finally(() => {
            this.loading = false
          })
    }
  }
}
</script>

<style scoped lang="scss">
.order__list-link{
    text-decoration: none;
}
</style>