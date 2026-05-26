import type { RouteRecordRaw } from 'vue-router'

export const appRoutes: RouteRecordRaw[] = [
    {
        path: '/login',
        component: () => import('@/views/auth/login/index.vue'),
        name: 'Login',
        meta: {
            hidden: true,
            title: '登录',
            noTagsView: true
        }
    },
    {
        path: '/',
        component: () => import('@/layouts/index.vue'),
        redirect: '/home',
        meta: { hidden: true, noTagsView: true },
        children: [
            {
                path: 'home',
                name: 'Home',
                component: () => import('@/views/home/index.vue'),
                meta: {
                    title: '首页',
                    icon: 'ep:HomeFilled',
                    noTagsView: false,
                    hidden: true,
                    affix: true
                }
            }
        ]
    },
    {
        path: '/user',
        component: () => import('@/layouts/index.vue'),
        name: 'User',
        meta: {
            hidden: false,
            title: '用户',
            noTagsView: false,
            icon: 'ep:User'
        },
        children: [
            {
                path: '/user/users',
                component: () => import('@/views/user/users/index.vue'),
                name: 'UserUser',
                meta: { hidden: false, title: '用户列表', noTagsView: false, icon: 'ep:List' }
            },
            {
                path: '/user/administrators',
                component: () => import('@/views/user/administrators/index.vue'),
                name: 'UserAdministrator',
                meta: { hidden: false, title: '管理员列表', noTagsView: false, icon: 'ep:List' }
            },
            {
                path: '/user/roles',
                component: () => import('@/views/user/roles/index.vue'),
                name: 'UserRole',
                meta: { hidden: false, title: '角色列表', noTagsView: false, icon: 'ep:List' }
            }
        ]
    },
    {
        path: '/shop',
        component: () => import('@/layouts/index.vue'),
        name: 'Shop',
        meta: {
            hidden: false,
            title: '商城',
            noTagsView: false,
            icon: 'ep:Shop'
        },
        children: [
            {
                path: '/shop/categories',
                component: () => import('@/views/shop/categories/index.vue'),
                name: 'ShopCategory',
                meta: { hidden: false, title: '分类列表', noTagsView: false, icon: 'ep:List' }
            },
            {
                path: '/shop/products',
                component: () => import('@/views/shop/products/index.vue'),
                name: 'ShopProduct',
                meta: { hidden: false, title: '产品列表', noTagsView: false, icon: 'ep:List' }
            },
            {
                path: '/shop/actors',
                component: () => import('@/views/shop/actors/index.vue'),
                name: 'ShopActor',
                meta: { hidden: false, title: '演员列表', noTagsView: false, icon: 'ep:List' }
            },
            {
                path: '/shop/athletes',
                component: () => import('@/views/shop/athletes/index.vue'),
                name: 'ShopAthlete',
                meta: { hidden: false, title: '运动员列表', noTagsView: false, icon: 'ep:List' }
            },
        ]
    }
]
