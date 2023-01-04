import { createWebHistory, createRouter } from 'vue-router';

const Home = () => import('../components/home.vue');

const routes = [
    {
        name: "Home",
        path: "/",
        component: Home,
    },
]

const router = createRouter({
    history: createWebHistory(),
    routes,
})

router.beforeEach((to, from, next) => {
    document.title = to.meta.title;
    next();
})
export default router