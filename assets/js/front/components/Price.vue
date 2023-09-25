<template>
  <div class="tour__details_wrap">
    <LoaderLocal
        v-if="loading"
        class="tour__review-loader"
        :size="30"
        :height="30"
    />
    <div v-else  class="tour__details-header-price">
      <span>{{ this.getMainPrice() }}</span>
      <svg class="icon currency">
        <use xlink:href="#GEL"></use>
      </svg>
    </div>
    <v-popover placement="top">
      <svg class="icon quest">
        <use xlink:href="#quest"></use>
      </svg>
      <template slot="popover">
        <div class="tooltip-content">
          <span v-for="price in this.priceList" class="tooltip-content__row">
            <svg class="icon currency">
              <use :xlink:href="'#flag-' + price.currency"></use>
            </svg>
            {{ price.price }}
            {{ price.currency }}
          </span>
         </div>
      </template>
    </v-popover>

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
      prices: [],
    }
  },
  computed: {
    priceList() {
      return this.prices.filter(item => item.currency !== "GEL");
    },
  },
  mounted () {
    this.getPrice()
  },
  methods: {
    getMainPrice(){
      let gelCurrency = this.prices.find(item => item.currency === "GEL")
      return gelCurrency?.price
    },
    getPrice() {
      this.loading = true
      axios.get(`/tour/get-price/${this.tripId}`)
          .then((response) => {
            this.prices = response.data
          })
          .catch((error) => {
            this.prices = 'Не получилось получить'
          })
          .finally(() => {
            this.loading = false
          });
    },
  },
}
</script>

<style scoped lang="scss">
.tour__details_wrap{
  display: flex;
  align-items: center;
  gap: 12px
}
.quest{
  width: 30px;
  height: 30px;
  cursor: pointer;
}
.tooltip-content{
  display: flex;
  flex-direction: column;
  font-family: Manrope,sans-serif;
  font-size: 14px;
  font-weight: 600;
  line-height: 22px;
  &__row{
    display: flex;
    align-items: center;
    gap: 12px;
  }
}
</style>