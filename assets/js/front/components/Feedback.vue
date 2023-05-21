<template>
  <v-app >

    <div class="wrap">
      <div class="feedback__header">
        Отзывы
      </div>
      <div class="feedback__list">
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
                <div class="feedback__comment-text">
                  {{comment.text}}
                  <a href="#" class="feedback__comment-link">читать полностью</a>
                </div>
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

  </v-app>
</template>

<script>
import { Swiper, SwiperSlide, directive } from 'vue-awesome-swiper'

// Import Swiper styles
import 'swiper/css/swiper.css'

export default {
  name: "Feedback",
  components: {
    Swiper,
    SwiperSlide,
  },
  directives: {
    swiper: directive
  },
  data() {
    return {
      showPopup: false,
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
      computed: {
        swiper() {
          return this.$refs.mySwiper.$swiper
        }
      },
      mounted() {
        console.log('Current Swiper instance object', this.swiper)
        this.swiper.slideTo(3, 1000, false)
      },
      comments:[
        {
          id: 1,
          author: 'Alex',
          text: 'Давид - крутой рассказчик, который любит свою страну и ее историю. За день удалось увидеть сразу несколько интересных мест, познакомиться с местными колоритными жителями, а также (что самое интересное) ',
          stars: 5
        },
        {
          id: 2,
          author: 'Alex',
          text: 'Давид - крутой рассказчик, который любит свою страну и ее историю. За день удалось увидеть сразу несколько интересных мест, познакомиться с местными колоритными жителями, а также (что самое интересное) ',
          stars: 4
        },
        {
          id: 3,
          author: 'Alex',
          text: 'Давид - крутой рассказчик, который любит свою страну и ее историю. За день удалось увидеть сразу несколько интересных мест, познакомиться с местными колоритными жителями, а также (что самое интересное) ',
          stars: 3
        },
        {
          id: 4,
          author: 'Alex',
          text: 'Давид - крутой рассказчик, который любит свою страну и ее историю. За день удалось увидеть сразу несколько интересных мест, познакомиться с местными колоритными жителями, а также (что самое интересное) ',
          stars: 4
        },
        {
          id: 5,
          author: 'Alex',
          text: 'Давид - крутой рассказчик, который любит свою страну и ее историю. За день удалось увидеть сразу несколько интересных мест, познакомиться с местными колоритными жителями, а также (что самое интересное) ',
          stars: 5
        },
      ]
    };
  },
  methods: {

  },
};
</script>

<style scoped lang="scss">
::v-deep .v-application--wrap {
  min-height: fit-content;
}

</style>