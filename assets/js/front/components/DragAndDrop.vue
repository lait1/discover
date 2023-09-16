<template>
  <div id="drag">
    <drag-and-drop-area @file-dropped="handleFileDrop" />
  </div>
</template>

<script>
import DragAndDropArea from "./DragAndDropArea";
import DragAndDropImages from "./DragAndDropImages";

export default {
  components: {
    DragAndDropArea,
    DragAndDropImages,
  },
  data() {
    return {
      selectedImages: [],
    };
  },
  methods: {
    handleFileDrop(files) {
      this.$emit('file-dropped', files);
    },
  },
};
</script>

<style>
#drag {
  font-family: Avenir, Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  text-align: center;
  color: #2c3e50;
}
</style>
