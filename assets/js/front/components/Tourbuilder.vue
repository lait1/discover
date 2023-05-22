<template>
  <v-app >
    <img src="/build/images/cloud_bg_trip_builder.png" alt="cloud" class="trip-builder__cloud">
    <div class="wrap">
      <div class="trip-builder__content">
        <div class="trip-builder__header">
          НЕТ ПОДХОДЯЩЕГО ТУРА? СОЗДАЙТЕ СВОЙ!
        </div>
        <svg class="icon">
          <use xlink:href="#lightning"></use>
        </svg>
        <div class="trip-builder__title">
          Выберите интересующие темы и укажите ваш номер телефона. Мы подберем экскурсию и свяжемся с вами!
        </div>
        <a class="trip-builder__button_chose-tour" href="#">Собрать тур</a>

      </div>

      <svg class="trip-builder__tooltip icon" v-tooltip="{content: contentTooltip, delay:{ hide: 500 }}" >
        <use xlink:href="#tooltip"></use>
      </svg>

    </div>
  </v-app>
</template>

<script>


export default {
  name: "Tourbuilder",
  data () {
    return {
      contentTooltip: '<span class="tooltip-content">Тур в горы <br>\n' +
          ' <a href="#" class="trip-builder__link">Посмотрет больше</a></span>',
    }
  }
};
</script>

<style scoped lang="scss">
.v-application a {
    color: #ffffff;
}
</style>