import '@fortawesome/fontawesome-free/css/all.css'
import '@morioh/v-lightbox/dist/lightbox.css';
import Vue from 'vue'
import Vuetify from 'vuetify/lib'
import Trailer from "./components/Trailer";
import VueYouTube from 'vue-youtube'
import Tourbuilder from "./components/Tourbuilder";
import Feedback from "./components/Feedback";
import { VTooltip } from 'v-tooltip'
import Tourgallery from "./components/TourGallery";
import Lightbox from '@morioh/v-lightbox'
import Calendar from "./components/Calendar";
import Faq from "./components/Faq";
import Reviews from "./components/Reviews";
import Price from "./components/Price";


Vue.directive('tooltip', VTooltip)

Vue.use(Lightbox);
Vue.use(VueYouTube)
Vue.use(Vuetify)

new Vue({
    vuetify: new Vuetify(),
    components: {Calendar, Trailer, Tourbuilder, Feedback, Tourgallery, Faq, Reviews, Price }
}).$mount('#app')


