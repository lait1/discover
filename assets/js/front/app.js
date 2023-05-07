import Vue from 'vue'
import App from './App.vue';
import Gallery from './components/Gallery.vue';

import Vuetify from 'vuetify/lib'
import Calendar from "./components/Calendar";

Vue.use(Vuetify)

new Vue({
    vuetify: new Vuetify(),
    components: {App, Gallery, Calendar}
}).$mount('#app')


