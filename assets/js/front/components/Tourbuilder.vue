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

      <v-tooltip
          bottom
          close-delay="500"
          z-index="3"
      >
        <template v-slot:activator="{ on, attrs }">
            <svg class="trip-builder__tooltip icon"
                 v-bind="attrs"
                 v-on="on">
              <use xlink:href="#tooltip"></use>
            </svg>
        </template>
          <span>Тур в горы <br>
          <a href="#" class="trip-builder__link">Посмотрет больше</a></span>
      </v-tooltip>

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