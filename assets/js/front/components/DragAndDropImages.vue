<template>
  <div class="image-container">
    <div v-for="(image, index) in images" :key="index" class="image-wrap">
      <img class="image" :src="image" alt="Selected Image" />
      <button
          @click.stop="removePhoto(index)"
          v-bind:data-id="image.id"
          type="button"
          class="delete fa fa-remove">
      </button>
    </div>
  </div>
</template>

<script>

export default {
  name: "DragAndDropImages",
  props: ['images'],
  methods:{
    removePhoto(index) {
      this.$emit('removeFile', index);
    },
  }
};
</script>

<style scoped lang="scss">
.image {
  &-container {
    display: flex;
    flex-wrap: wrap;
    justify-content: space-between;
    gap: 4px;
  }
  &-wrap {
    position: relative;
    &:hover img {
      filter: brightness(40%);
    }
    &:hover button {
      display: block;
    }
    img {
      max-width: 100%;
      max-height: 100px;
    }
    button {
      position: absolute;
      right: 5px;
      top: 5px;
      color: #fff;
      background: transparent;
      border: none;
      font-size: 20px;
      display: none;
    }
  }
}
</style>
