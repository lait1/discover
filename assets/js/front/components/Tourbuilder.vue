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

      <v-popover
          offset="16"
      >
        <svg class="tooltip-target trip-builder__tooltip icon">
          <use xlink:href="#tooltip"></use>
        </svg>

        <template slot="popover">
          <span class="tooltip-content">Тур в горы <br>
          <a href="#" class="trip-builder__link">Посмотрет больше</a></span>

        </template>
      </v-popover>
    </div>
  </v-app>
</template>

<script>


export default {
  name: "Tourbuilder",
};
</script>

<style scoped lang="scss">
.v-application a {
    color: #ffffff;
}
</style>