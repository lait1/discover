import '@fortawesome/fontawesome-free/css/all.css'
import '@morioh/v-lightbox/dist/lightbox.css';
import Vue from 'vue'
import Vuetify from 'vuetify/lib'
import App from './App.vue';
import Gallery from './components/Gallery.vue';
import Trailer from "./components/Trailer";
import VueYouTube from 'vue-youtube'
import Tourbuilder from "./components/Tourbuilder";
import Feedback from "./components/Feedback";
import { VTooltip, VPopover, VClosePopover } from 'v-tooltip'
import Tourgallery from "./components/TourGallery";
import Lightbox from '@morioh/v-lightbox'
import Calendar from "./components/Calendar";


Vue.use(Lightbox);
Vue.directive('tooltip', VTooltip)
Vue.directive('close-popover', VClosePopover)
Vue.component('v-popover', VPopover)

Vue.use(VueYouTube)

Vue.use(Vuetify)

new Vue({
    vuetify: new Vuetify(),
    components: {App, Calendar, Gallery, Trailer, Tourbuilder, Feedback, Tourgallery}
}).$mount('#app')


