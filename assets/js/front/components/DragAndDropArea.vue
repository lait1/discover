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
    <input type="file" ref="fileInput" multiple @change="handleFileInput" style="display: none" />
  </div>
</template>

<script>
import DragAndDropImages from "./DragAndDropImages";

export default {
  name: "DragAndDropArea",
  components: {
    DragAndDropImages,
  },
  data() {
    return {
      selectedImages: [],
    };
  },
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
      if (files.length > 0) {
        this.handleFileDrop(files)
      }
    },
    removePhoto(index){
      this.selectedImages.splice(index, 1)
    },
    handleFileInput() {
      const files = this.$refs.fileInput.files;
      if (files.length > 0) {
        this.handleFileDrop(files)
      }
    },
    handleFileDrop(files) {
      // Handle dropped files (in this case, assume they are images)
      for (let i = 0; i < files.length; i++) {
        const file = files[i];
        const reader = new FileReader();

        reader.onload = (e) => {
          this.selectedImages.push(e.target.result);
        };

        reader.readAsDataURL(file);
      }
      this.$emit('file-dropped', files);
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
