<template>
  <div
    class="widget-loader d-flex align-center justify-center w-100 h-100"
    :style="{
      minHeight: this.height ? `${this.height}px` : null,
    }"
  >
    <VProgressCircular
      color="secondary"
      :size="this.size"
      :width="this.width"
      indeterminate
    />
  </div>
</template>
<script>
export default {
  name: "LoaderLocal",
  props: {
    height: {
      type: Number,
      default: 50
    },
    minWidth: {
      type: Number,
      default: undefined
    },
    size: {
      type: Number,
      default: 30
    },
    width: {
      type: Number,
      default: 3
    }
  },
};
</script>
<style lang="scss" scoped>
.widget-loader {
  transition: background-color ease-in-out 150ms;
  left: 0;
  top: 0;
}
</style>
