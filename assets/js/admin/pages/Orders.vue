<template>
  <div>
    <h1>orders</h1>
  </div>
</template>

<script>
import axiosInstance from "../requestService";

export default {
  name: "Orders",
  data: () => ({
    loading: false,
    orders: []
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
    }
  }
}
</script>

<style scoped>

</style>