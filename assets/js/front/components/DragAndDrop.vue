<template>
  <div id="drag">
    <drag-and-drop-area
        :selected-images="selectedImages"
        @remove-file="removeFile"
        @file-dropped="handleFileDrop"
    />
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
  props: ['selectedImages'],
  methods: {
    handleFileDrop(files) {
      this.$emit('file-dropped', files);
    },
    removeFile(index){
      this.$emit('remove-file', index);
    }
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
