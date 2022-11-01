import {createRouter, createWebHistory} from 'vue-router';

const router = createRouter({
    history: createWebHistory(),
    routes: [
        {
            path: '/',
            component: () => import('./pages/Login.vue')
        },
        {
            path: '/register',
            component: () => import('./pages/Register.vue')
        },
        {
            path: '/home',
            component: () => import('./pages/Home.vue')
        }
    ],
})
router.beforeEach((to, from, next) => {
    if (to.path !== '/' && to.path !== '/register' && !isAuthenticated()) {
        return next({path: '/'})
    }
    return next()
})

function isAuthenticated() {
    return Boolean(localStorage.getItem('APP_DEMO_USER_TOKEN'))
}

export default router;
