import { createRouter, createWebHistory } from 'vue-router';
import Home from './pages/Home.vue';
import About from './pages/About.vue';

const router = createRouter({
    history: createWebHistory(),
    routes: [
        {
            path: '/admin/test',
            component: Home
        },
        {
            path: '/admin/about',
            component: About
        }
    ]
});

export default router;
