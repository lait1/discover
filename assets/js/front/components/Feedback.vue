<template>
    <div class="wrap">
      <div class="feedback__header">
        Отзывы
      </div>
      <LoaderLocal
          v-if="loading"
          class="tour__review-loader"
          :size="100"
          :min-width="100"
      />
      <div v-else class="feedback__list">
        <swiper ref="mySwiper" :options="swiperOptions">
          <swiper-slide
          v-for="comment in comments"
          :key="comment.id"
          >
            <div class="feedback__item">
              <div class="feedback__stars">
                <svg class="icon"
                     v-for="(star, index) in comment.stars"
                     :key="index"
                >
                  <use xlink:href="#star"></use>
                </svg>

              </div>
              <div class="feedback__comment">
                <div class="feedback__comment-author">
                  {{comment.author}}
                </div>
                <div class="feedback__comment-date">
                  {{comment.date}}
                </div>
                <div class="feedback__comment-text">
                  {{comment.shortText}}
                </div>
                <a :href="comment.linkTour" class="feedback__comment-link">Посмотреть отзыв</a>
              </div>
            </div>
          </swiper-slide>
        </swiper>
        <div class="feedback__arrow button-prev">
          <svg class="icon">
            <use xlink:href="#arrow-feedback"></use>
          </svg>
        </div>
        <div class="feedback__arrow button-next">
          <svg class="icon">
            <use xlink:href="#arrow-feedback"></use>
          </svg>
        </div>
      </div>
    </div>
</template>

<script>
import { Swiper, SwiperSlide, directive } from 'vue-awesome-swiper'

import 'swiper/css/swiper.css'
import axios from "axios";
import LoaderLocal from "./LoaderLocal";

export default {
  name: "Feedback",
  components: {
    Swiper,
    SwiperSlide,
    LoaderLocal
  },
  directives: {
    swiper: directive
  },
  data() {
    return {
      showPopup: false,
      loading: false,
      startItem: 1,
      swiperOptions: {
        slidesPerView: 3,
        slidesPerColumn: 1,
        spaceBetween: 24,
        navigation: {
          nextEl: '.button-next',
          prevEl: '.button-prev'
        },
        breakpoints: {
          1024: {
            slidesPerView: 3,
            spaceBetween: 24
          },
          768: {
            slidesPerView: 2,
            spaceBetween: 24
          },
          640: {
            slidesPerView: 1,
            spaceBetween: 20
          },
          320: {
            slidesPerView: 1,
            spaceBetween: 10
          }
        }
      },
      comments:[],
      computed: {
        swiper() {
          return this.$refs.mySwiper.$swiper
        }
      },
    };
  },
  mounted() {
    this.getBestComments();
  },
  methods: {
    getBestComments() {
      this.loading = true
      axios.get(`/comment/get-best-comments/`)
          .then((response) => {
            this.comments = response.data
          })
          .catch((response) => {
            alert("Ошибка загрузки комментов");
          })
          .finally(() => {
            this.loading = false
          })
    }
  },
};
</script>

<style scoped lang="scss">
::v-deep .v-application--wrap {
  min-height: fit-content;
}

</style>