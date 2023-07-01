<template>
  <div class="wrap">
    <div class="tour__faq-info">
      <h1>Гостям интересно</h1>
      <p>Не нашли ответа на свой вопрос? <br>
        Напишите к нам в чат или в наши социальные сети. Мы с радостью вам поможем!
      </p>
      <div class="tour__faq-social">
        <a href="https://t.me/your_name" target="_blank"
           title="Написать в Telegram">
          <svg class="icon">
            <use xlink:href="#telegram"></use>
          </svg>
        </a>
        <a href="https://t.me/your_name" target="_blank"
           title="Написать в Whatsapp">
          <svg class="icon">
            <use xlink:href="#whatsapp"></use>
          </svg>
        </a>
      </div>
    </div>
    <div class="tour__faq-content">
      <div v-for="item in items" class="tour__faq-item">
        <div class="tour__faq-item__title" @click.prevent="item.isActive = !item.isActive">
          <span>{{ item.title }}</span>
            <svg class="icon">
              <use :xlink:href='item.isActive ? "#minus-faq" : "#plus-faq"'></use>
            </svg>
        </div>

        <div class="tour__faq-item__description" v-show="item.isActive">
         {{ item.description }}
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "Faq",
  data: () => ({
    items: [
      {
        id: 1,
        title: 'Как забронировать?',
        description: 'A 20% prepayment is required for booking. To do this, select a tour and send an application. The date will already be yours! Then, our manager will contact you and send you a link for prepayment. And that\'s it, we will be looking forward to meeting you!',
        isActive: false,
      },
      {
        id: 1,
        title: 'Как забронировать?',
        description: 'A 20% prepayment is required for booking. To do this, select a tour and send an application. The date will already be yours! Then, our manager will contact you and send you a link for prepayment. And that\'s it, we will be looking forward to meeting you!',
        isActive: false,
      },
      {
        id: 1,
        title: 'Как забронировать?',
        description: 'A 20% prepayment is required for booking. To do this, select a tour and send an application. The date will already be yours! Then, our manager will contact you and send you a link for prepayment. And that\'s it, we will be looking forward to meeting you!',
        isActive: false,
      },
    ],
  }),
  methods: {
    choseDate() {

    },
  },
};
</script>

<style scoped lang="scss">
::v-deep .v-application--wrap {
  min-height: fit-content;
}

</style>