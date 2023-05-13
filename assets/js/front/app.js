import Vue from 'vue'
import Vuetify from 'vuetify/lib'
import App from './App.vue';
import Gallery from './components/Gallery.vue';
import Calendar from "./components/Calendar";
import Trailer from "./components/Trailer";
import VueYouTube from 'vue-youtube'

Vue.use(VueYouTube)

Vue.use(Vuetify)

new Vue({
    vuetify: new Vuetify(),
    components: {App, Gallery, Calendar, Trailer}
}).$mount('#app')


