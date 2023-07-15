<template>
  <div>
    <h1>{{ message }}</h1>
  </div>
</template>

<script>
import { mapState, mapActions } from 'vuex'

export default {
  computed: {
    ...mapState(['message'])
  },
  methods: {
    ...mapActions(['fetchMessage'])
  },
  created() {
    this.fetchMessage()
  }
}
</script>