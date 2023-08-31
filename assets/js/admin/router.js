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
        path: '/admin/dashboard',
        name: 'dashboard',
        authGuard: true,
        component: () => import('./pages/Dashboard.vue')
    },
    {
        path: '/admin/tours',
        name: 'tours',
        authGuard: true,
        component: () => import('./pages/Tours.vue')
    },
    {
        path: '/admin/orders',
        name: 'orders',
        authGuard: true,
        component: () => import('./pages/Orders.vue')
    },
    {
        path: '/admin/clients',
        name: 'clients',
        authGuard: true,
        component: () => import('./pages/Clients.vue')
    },
    {
        path: '/admin/users',
        name: 'users',
        authGuard: true,
        component: () => import('./pages/Users.vue')
    },
    {
        path: '/admin/settings',
        name: 'settings',
        authGuard: true,
        component: () => import('./pages/Settings.vue')
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
