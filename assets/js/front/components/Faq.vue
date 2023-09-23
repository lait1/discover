<template>
  <div class="wrap">
    <div class="tour__faq-info">
      <h1 class="tour__faq-info-header">Гостям интересно</h1>
      <p>Не нашли ответа на свой вопрос? <br>
        Напишите к нам в чат или в наши социальные сети. Мы с радостью вам поможем!
      </p>
      <div class="tour__faq-social">
        <a v-if="telegramLink" :href="telegramLink" target="_blank"
           title="Написать в Telegram">
          <svg class="icon">
            <use xlink:href="#telegram"></use>
          </svg>
        </a>
        <a v-if="whatsappLink" :href="whatsappLink" target="_blank"
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
          <div>
            <svg class="icon">
              <use :xlink:href='item.isActive ? "#minus-faq" : "#plus-faq"'></use>
            </svg>
          </div>
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
  props:['telegramLink', 'whatsappLink'],
  data: () => ({
    items: [
      {
        id: 1,
        title: 'Зачем вносить предоплату?',
        description: 'Внесение предоплаты в размере 20% позволяет нам обеспечить вам гарантированное место на экскурсии и зарезервировать необходимые ресурсы, такие как гиды и транспорт.\n' +
            '\n' +
            'После подтверждения бронирования наш менеджер вышлет вам все необходимые данные для внесения предоплаты. Вы можете произвести оплату как с российской, так и с грузинской карты. Если эти способы оплаты вам не подходят, не переживайте. Мы найдем для вас наиболее удобный вариант оплаты. Ваш комфорт - наш приоритет.',
        isActive: false,
      },
      {
        id: 2,
        title: 'Сколько человек может посетить экскурсию?',
        description: 'Стоимость экскурсии обычно рассчитывается до 4-х человек. Вы можете увеличить количество участников, обратившись к нам. Мы рассчитаем новую стоимость и предложим вам оптимальные варианты.',
        isActive: false,
      },
      {
        id: 3,
        title: 'Как мне добать в экскурсию профессиональные фото и видео с дрона?',
        description: 'Если вы хотите добавить дополнительные опции к вашей индивидуальной экскурсии, напишите нам. Мы договоримся о дополнительных услугах и стоимости, чтобы сделать вашу экскурсию незабываемой и визуально привлекательной.',
        isActive: false,
      },
      {
        id: 4,
        title: 'Могу ли я изменить маршрут экскурсии?',
        description: 'Мы готовы адаптировать маршрут под ваши желания и интересы, включая добавление новых локаций или корректировку существующих. Однако важно помнить, что изменение маршрута может повлиять на стоимость экскурсии, так как она зависит от расстояния, времени и других факторов.\n' +
            '\n' +
            'Чтобы учесть ваши пожелания и предоставить вам наилучший опыт, пожалуйста, свяжитесь с нами заранее и обсудите все детали. Мы постараемся сделать всё возможное, чтобы удовлетворить ваши запросы и предоставить вам незабываемую экскурсию!',
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