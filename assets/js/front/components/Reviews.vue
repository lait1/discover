<template>
  <div class="wrap">
    <h1 class="tour__reviews-header">
      ОТЗЫВЫ НАШИХ ПУТЕШЕСТВЕННИКОВ
    </h1>
    <div class="tour__review-list">
      <LoaderLocal
          v-if="loading"
          class="tour__review-loader"
          :size="100"
          :min-width="100"
      />
      <div class="tour__review"
           v-for="comment in comments"
      >
        <div class="tour__review-top">
          <div class="tour__review-top__userinfo">
            <h3 class="tour__review-top__username">
              {{ comment.author }}
            </h3>
            <div class="tour__review-top__stars">
              <svg class="icon"
                   v-for="(star, index) in comment.stars"
                   :key="index">
                <use xlink:href="#star"></use>
              </svg>
            </div>
          </div>
          <div class="tour__review-top__date">
            {{ comment.date }}
          </div>
        </div>
        <p class="tour__review-text">{{ comment.text }}</p>
      </div>
    </div>
    <div class="tour__review-actions">
      <button @click="addComment" class="tour__review-add-comment">Добавить отзыв</button>
    </div>
    <Commentdialog
        v-model="this.showCommentDialog"
        :trip-id="this.tripId"
        @closeDialog="closeDialog"
        @showSuccessMessage="showSuccessMessage"
        @showErrorMessage="showErrorMessage"
    />
    <Alertdialog
        v-model="this.showAlert"
        :message="this.alertMessage"
        :hasError="this.hasError"
        @closeAlert="closeAlert"
    />
  </div>
</template>

<script>
import Commentdialog from "./CommentDialog";
import axios from "axios";
import Alertdialog from "./AlertDialog";
import LoaderLocal from "./LoaderLocal";

export default {
  name: "Reviews",
  components: {Alertdialog, Commentdialog, LoaderLocal },
  props:['tripId'],
  data: () => ({
    loading: false,
    showCommentDialog: false,
    showAlert: false,
    alertMessage: '',
    hasError: false,
    comments: []
  }),
  mounted() {
    this.getCommentsByTourId();
  },
  methods: {
    addComment() {
      this.showCommentDialog = true
    },
    closeDialog() {
      this.showCommentDialog = false
    },
    closeAlert(){
      this.showAlert = false
    },
    showSuccessMessage(message) {
      this.closeDialog()

      this.showAlert = true
      this.alertMessage = message
    },
    showErrorMessage(errorMessage) {
      this.closeDialog()

      this.showAlert = true
      this.hasError = true
      this.alertMessage = errorMessage
    },
    getCommentsByTourId() {
      this.loading = true
      axios.get(`/comment/get-comments/${this.tripId}/`)
          .then((response) => {
            this.comments = response.data
          })
          .catch((response) => {
            alert("Ошибка загрузки комментов");
          })
          .finally(() => {
            this.loading = false
          })
    },
  },
};
</script>
