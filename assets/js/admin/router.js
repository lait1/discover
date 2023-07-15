import Vue from 'vue'
import VueRouter from 'vue-router'
import AuthService from "./auth.service";


Vue.use(VueRouter)

const routes = [
    {
        path: '/admin/login',
        name: 'login',
        component: () => import('./App.vue')
    },
    {
        path: '/admin/home',
        name: 'home',
        authGuard: true,
        component: () => import('./pages/Home.vue')
    },
    {
        path: '/admin/about',
        name: 'about',
        authGuard: true,
        component: () => import('./pages/About.vue')
    }
]

const router = new VueRouter({
    mode: 'history',
    base: '/',
    routes
})
router.beforeEach((to, from, next) => {
    if (to.matched.some(m => m.authGuard) && !AuthService.isAuthenticated()){
        next({ name: "login" });
    }else{
        next();
    }
});
export default router
