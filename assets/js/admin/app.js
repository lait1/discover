import '@fortawesome/fontawesome-free/css/all.css'
import Vue from 'vue'
import Vuetify from 'vuetify/lib'
import App from './App.vue';
import router from './router.js';
import store from './stores/store'

Vue.use(Vuetify)

new Vue({
    vuetify: new Vuetify(),
    router,
    store,
    render: h => h(App)
}).$mount('#app')