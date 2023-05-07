import Vue from 'vue'
import VueRouter from 'vue-router'


Vue.use(VueRouter)

const routes = [
    {
        path: '/admin/home',
        name: 'home',
        component: () => import('./pages/Home.vue')
    },
    {
        path: '/admin/about',
        name: 'about',
        component: () => import('./pages/About.vue')
    }
]

const router = new VueRouter({
    mode: 'history',
    base: '/',
    routes
})

export default router
