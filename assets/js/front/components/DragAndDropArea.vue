<template>
  <div>
    <div
        class="drag-and-drop"
        @dragover.prevent
        @dragenter="dragEnter"
        @drop="drop"
        @click="openFilePicker"
    >
      <p v-if="selectedImages.length === 0">Выберите фотографии</p>
      <drag-and-drop-images
          :images="selectedImages"
          @removeFile="removePhoto"
      />
    </div>
    <input type="file" ref="fileInput" accept="image/jpeg,image/png" multiple @change="handleFileInput" style="display: none" />
  </div>
</template>

<script>
import DragAndDropImages from "./DragAndDropImages";

export default {
  name: "DragAndDropArea",
  components: {
    DragAndDropImages,
  },
  props: ['selectedImages'],
  methods: {
    dragEnter(event) {
      event.preventDefault();
      this.$el.classList.add('drag-over');
    },
    openFilePicker() {
      this.$refs.fileInput.click();
    },
    drop(event) {
      event.preventDefault();
      this.$el.classList.remove('drag-over');

      const files = event.dataTransfer.files;
      if (files.length > 0 && files.length < 7) {
        this.$emit('file-dropped', files);
      } else {
        alert('Вы можете загрузить только 6 фоток');
      }

   },
    removePhoto(index){
      this.$emit('remove-file', index);
    },
    handleFileInput() {
      const files = this.$refs.fileInput.files;
      if (files.length > 0 && files.length < 7) {
        this.$emit('file-dropped', files);
      } else {
        alert('Вы можете загрузить только 6 фоток');
      }
    },
  },
};
</script>

<style scoped lang="scss">
.drag-and-drop {
  min-height: 140px;
  padding: 20px;
  border-radius: 16px;
  border: 2px dashed #898998;
  background: #F6F6FA;
  text-align: center;
  display: flex;
  p{
    margin: auto;
  }
}

.drag-over {
  background-color: #f0f0f0;
}
</style>
