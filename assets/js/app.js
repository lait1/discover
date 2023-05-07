import Vue from 'vue'
import router from './router.js';
import App from './App.vue';
import store from './stores/store'

new Vue({
    router,
    store,
    render: h => h(App)
}).$mount('#app')