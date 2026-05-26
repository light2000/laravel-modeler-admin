import { defineStore } from 'pinia'
import { useTabsStore } from './tabs'
import { usePermissionStore } from './permission'
import type { UpdateProfileRes } from '@/api/modules/user/administrator.api'

export const useAuthStore = defineStore('auth', {
    state: (): {
        token: string
        administrator: UpdateProfileRes | null
    } => ({
        token: '',
        administrator: null
    }),

    actions: {
        setToken(token: string) {
            this.token = token
        },
        setAdministrator(administrator: UpdateProfileRes) {
            this.administrator = administrator
        },
        logout() {
            this.token = ''
            this.administrator = null
            const tabsStore = useTabsStore()
            tabsStore.delAllViews()
            const permissionStore = usePermissionStore()
            permissionStore.clearPermissions()
        }
    },
    persist: true
})
