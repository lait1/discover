<template>
  <div class="wrap">
    <h1 class="tour__reviews-header">
      ОТЗЫВЫ НАШИХ ПУТЕШЕСТВЕННИКОВ
    </h1>
    <div class="tour__review-list">
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
    <Commentdialog v-model="this.showPopup" :trip-id="this.tripId"  @closeDialog="closeDialog"/>
  </div>
</template>

<script>
import Commentdialog from "./CommentDialog";

export default {
  name: "Reviews",
  components: {Commentdialog},
  props:['tripId'],
  data: () => ({
    showPopup: false,
    comments: [
      {
        id: 1,
        author: 'Александр Еремеев',
        text: 'Давид - крутой рассказчик, который любит свою страну и ее историю. За день удалось увидеть сразу несколько интересных мест, познакомиться с местными колоритными жителями, а также (что самое интересное) ',
        stars: 5,
        date: '23 апреля 2023'
      },
      {
        id: 2,
        author: 'Ксюша Малышееееева',
        text: 'Давид - крутой рассказчик, который любит свою страну и ее историю. За день удалось увидеть сразу несколько интересных мест, познакомиться с местными колоритными жителями, а также (что самое интересное) ',
        stars: 4,
        date: '23 апреля 2023'
      },
      {
        id: 3,
        author: 'Ииииииииииигорь',
        text: 'Давид - крутой рассказчик, который любит свою страну и ее историю. За день удалось увидеть сразу несколько интересных мест, познакомиться с местными колоритными жителями, а также (что самое интересное) ',
        stars: 3,
        date: '23 апреля 2023'
      },
    ]
  }),
  methods: {
    addComment() {
      this.showPopup = true
    },
    closeDialog(){
      this.showPopup = false
    }
  },
};
</script>
