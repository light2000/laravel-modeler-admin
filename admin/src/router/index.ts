import { createRouter, createWebHashHistory } from 'vue-router'
import { useNProgress } from '@/composables/web/useNProgress'
import { useAuthStore } from '@/store/modules/auth'
import { usePermissionStore } from '@/store/modules/permission'
import { meApi } from '@/api/modules/user/administrator.api'
import { appRoutes } from './routes'

const { start, done } = useNProgress()

const ROUTER_WHITE_LIST = ['/login']

const router = createRouter({
    history: createWebHashHistory(),
    strict: true,
    routes: appRoutes,
    scrollBehavior: () => ({ left: 0, top: 0 })
})

router.beforeEach(async (to, from, next) => {
    const authStore = useAuthStore()
    const permissionStore = usePermissionStore()
    // 1.NProgress 开始
    start()

    // 2.白名单
    if (ROUTER_WHITE_LIST.includes(to.path)) {
        done()
        return next()
    }

    if (authStore.token && !authStore.administrator) {
        try {
            const response = await meApi.profile()
            authStore.setAdministrator(response)
        } catch {
            await authStore.logout()
            done()
            return next({ name: 'Login', replace: true })
        }
    }

    // 3.未登录
    if (!authStore.token) {
        return next({
            name: 'Login',
            replace: true
        })
    }

    // 4.已登录访问 login
    if (to.name === 'Login') {
        next({ path: '/' })
    }

    // 5.权限校验
    const permission = to.meta.permission as string | undefined
    if (permission && !permissionStore.permissions.includes(permission)) {
        done()
        return next({ path: '/403' })
    }

    next()
})

router.onError(() => {
    done()
})

router.afterEach(to => {
    const appTitle = import.meta.env.VITE_APP_NAME
    document.title = to.meta.title ? `${to.meta.title} - ${appTitle}` : appTitle
    done() // 结束Progress
})

export default router
