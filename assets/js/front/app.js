import '@fortawesome/fontawesome-free/css/all.css'
import Vue from 'vue'
import Vuetify from 'vuetify/lib'
import App from './App.vue';
import Gallery from './components/Gallery.vue';
import Trailer from "./components/Trailer";
import VueYouTube from 'vue-youtube'
import Tourbuilder from "./components/Tourbuilder";
import Feedback from "./components/Feedback";
import { VTooltip, VPopover, VClosePopover } from 'v-tooltip'

Vue.directive('tooltip', VTooltip)
Vue.directive('close-popover', VClosePopover)
Vue.component('v-popover', VPopover)

Vue.use(VueYouTube)

Vue.use(Vuetify)

new Vue({
    vuetify: new Vuetify(),
    components: {App, Gallery, Trailer, Tourbuilder, Feedback}
}).$mount('#app')


