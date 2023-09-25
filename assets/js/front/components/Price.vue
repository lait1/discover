<template>
  <div class="tour__details-header-price">
    <LoaderLocal
        v-if="loading"
        class="tour__review-loader"
        :size="30"
        :height="30"
    />
    <span v-else>{{ this.getMainPrice() }}</span>
      <svg class="icon currency">
        <use xlink:href="#GEL"></use>
      </svg>
  </div>
</template>

<script>
import axios from "axios";
import LoaderLocal from "./LoaderLocal";

export default {
  name: "Price",
  components:{
    LoaderLocal
  },
  props:['tripId'],
  data () {
    return {
      loading: false,
      price: [],
      tooltip: {
        content: '<span class="tooltip-content"></span>',
        delay: 500
      }
    }
  },
  mounted () {
    this.getPrice()
  },
  methods: {
    getMainPrice(){
      let gelCurrency = this.price.find(item => item.currency === "GEL")
      return gelCurrency?.price
    },
    getPrice() {
      this.loading = true
      axios.get(`/tour/get-price/${this.tripId}`)
          .then((response) => {
            this.price = response.data
          })
          .catch((error) => {
            this.price = 'Не получилось получить'
          })
          .finally(() => {
            this.loading = false
          });
    },
  },
}
</script>

<style scoped>

</style>