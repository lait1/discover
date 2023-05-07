<template>
  <VFooter
      color="primary lighten-1"
      padless
  >
    <VRow
        justify="center"
        no-gutters
    >
      <VBtn
          color="white"
          text
          rounded
          class="my-2"
      >
        test
      </VBtn>
      <VCol
          class="primary lighten-2 py-4 text-center white--text"
          cols="12"
      >
        {{ new Date().getFullYear() }} — <strong>Vuetify</strong>
      </VCol>
    </VRow>
  </VFooter>
</template>

<script>
import {VBtn, VCol, VFooter, VRow} from "vuetify/lib/components";

export default {
  components: {
    VFooter,
    VRow,
    VBtn,
    VCol
  },
  data() {
    return {
      message: 'I am Vue component'
    };
  }
};
</script>