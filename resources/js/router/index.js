import { createWebHistory, createRouter } from "vue-router";
import pinia from "../store/index"
import {useAuthStore} from "../store/auth"
import middlewarePipeline from './middlewarePipeline'
import auth from "../middlewares/auth"
import guest from "../middlewares/guest"

const routes = [
    {
        path: '/login',
        name: 'login',
        component:() => import('../pages/auth/Login.vue'),
        meta: {
            middleware: [
                guest,
            ]
        }
    },
    /**
     * Company route
     */
    {
        path: '/company',
        name: 'company.index',
        component:() => import('../pages/company/index.vue'),
        meta: {
            middleware: [
                auth,
            ]
        }
    },
    {
        path: '/company/create',
        name: 'company.create',
        component:() => import('../pages/company/create.vue'),
        meta: {
            middleware: [
                auth,
            ]
        }
    },
    {
        path: '/company/:id',
        name: 'company.show',
        component:() => import('../pages/company/show.vue'),
        meta: {
            middleware: [
                auth,
            ]
        }
    },
    {
        path: '/company/:id/edit',
        name: 'company.edit',
        component:() => import('../pages/company/edit.vue'),
        meta: {
            middleware: [
                auth,
            ]
        }
    },
    /**
     * Department route
     */
     {
        path: '/department',
        name: 'department.index',
        component:() => import('../pages/department/index.vue'),
        meta: {
            middleware: [
                auth,
            ]
        }
    },
    {
        path: '/department/create',
        name: 'department.create',
        component:() => import('../pages/department/create.vue'),
        meta: {
            middleware: [
                auth,
            ]
        }
    },
    {
        path: '/department/:id',
        name: 'department.show',
        component:() => import('../pages/department/show.vue'),
        meta: {
            middleware: [
                auth,
            ]
        }
    },
    {
        path: '/department/:id/edit',
        name: 'department.edit',
        component:() => import('../pages/department/edit.vue'),
        meta: {
            middleware: [
                auth,
            ]
        }
    },
    /**
     * Employee route
     */
     {
        path: '/employee',
        name: 'employee.index',
        component:() => import('../pages/employee/index.vue'),
        meta: {
            middleware: [
                auth,
            ]
        }
    },
    {
        path: '/employee/create',
        name: 'employee.create',
        component:() => import('../pages/employee/create.vue'),
        meta: {
            middleware: [
                auth,
            ]
        }
    },
    {
        path: '/employee/:id',
        name: 'employee.show',
        component:() => import('../pages/employee/show.vue'),
        meta: {
            middleware: [
                auth,
            ]
        }
    },
    {
        path: '/employee/:id/edit',
        name: 'employee.edit',
        component:() => import('../pages/employee/edit.vue'),
        meta: {
            middleware: [
                auth,
            ]
        }
    },
]
const router = createRouter({
    history: createWebHistory(),
    routes: routes
})

router.beforeEach((to, from, next) => {

    const store = useAuthStore();

    if (!to.meta?.middleware) {
        return next()
    }

    const middleware = to.meta?.middleware

    if (!(middleware.length > 0))
        return next();

    const context = {
        to,
        from,
        next,
        store
    }

    // store.init();

    return middleware[0]({
        ...context,
        next: middlewarePipeline(context, middleware, 1)
    })

})

export default router