import { createWebHistory, createRouter } from "vue-router";

const routes = [
    {
        path: '/',
        name: 'home',
        component:() => import('../pages/index.vue'),
    }
]
const router = createRouter({
    history: createWebHistory(),
    routes: routes
})

export default router