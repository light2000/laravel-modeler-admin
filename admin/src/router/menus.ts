import type { RouteRecordRaw } from 'vue-router'
import type { MenuItem } from '@/store/modules/permission'

function routeToMenu(route: RouteRecordRaw): MenuItem | null {
    if (route.meta?.hidden) return null
    if (route.redirect) return null

    return {
        path: route.path,
        name: route.name,
        meta: {
            title: route.meta?.title as string,
            icon: route.meta?.icon as string
        },
        children: route.children?.map(routeToMenu).filter((item): item is MenuItem => !!item)
    }
}

export function buildGeneratedMenus(routes: RouteRecordRaw[]): MenuItem[] {
    return routes.map(routeToMenu).filter((item): item is MenuItem => !!item)
}

export function overrideMenus(menus: MenuItem[]): MenuItem[] {
    return menus
}
