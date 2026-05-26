import { defineStore } from 'pinia'
import type { RouteRecordRaw } from 'vue-router'
import { buildGeneratedMenus, overrideMenus } from '@/router/menus'

export interface MenuItem {
    path: string
    name?: string | symbol
    meta: {
        title: string
        icon?: string
    }
    children?: MenuItem[]
}

function filterRoutesByPermission(routes: RouteRecordRaw[], permissions: string[]): RouteRecordRaw[] {
    return routes
        .filter(route => {
            const p = route.meta?.permission
            return !p || permissions.includes(p as string)
        })
        .map(route => {
            const filtered: RouteRecordRaw = { ...route }
            if (route.children) {
                filtered.children = filterRoutesByPermission(route.children, permissions)
            }
            return filtered
        })
}

//面包屑映射
function getAllBreadcrumbMap(
    menuList: MenuItem[],
    parent: MenuItem[] = [],
    result: { [key: string]: MenuItem[] } = {}
): { [key: string]: MenuItem[] } {
    for (const item of menuList) {
        result[item.path] = [...parent, item]
        if (item.children) {
            getAllBreadcrumbMap(item.children, result[item.path], result)
        }
    }
    return result
}

export const usePermissionStore = defineStore('permission', {
    state: () => ({
        permissions: [] as string[],
        menus: [] as MenuItem[],
        breadcrumbMap: {} as { [key: string]: MenuItem[] }
    }),

    actions: {
        generateMenus(routes: RouteRecordRaw[], permissions: string[]) {
            this.permissions = permissions
            const accessibleRoutes = filterRoutesByPermission(routes, permissions)
            const generatedMenus = buildGeneratedMenus(accessibleRoutes)
            this.menus = overrideMenus(generatedMenus)
            this.breadcrumbMap = getAllBreadcrumbMap(this.menus)
        },
        clearPermissions() {
            this.permissions = []
            this.menus = []
            this.breadcrumbMap = {}
        }
    },
    persist: true
})
