import { nextTick } from 'vue'
import { defineStore } from 'pinia'
import type { RouteLocationNormalizedLoaded } from 'vue-router'
import router from '@/router'

export interface TabsState {
    visitedViews: RouteLocationNormalizedLoaded[]
    cachedViews: Set<string>
}

export const useTabsStore = defineStore('tabs', {
    state: (): TabsState => ({
        visitedViews: [],
        cachedViews: new Set()
    }),

    getters: {
        getVisitedViews: state => state.visitedViews,
        getCachedViews: state => Array.from(state.cachedViews)
    },

    actions: {
        /** 新增 tab + cache */
        addView(view: RouteLocationNormalizedLoaded) {
            this.addVisitedView({
                path: view.path,
                fullPath: view.fullPath,
                name: view.name,
                meta: view.meta
            } as RouteLocationNormalizedLoaded)
            this.addCachedView(view)
        },

        /** 新增 tab */
        addVisitedView(view: RouteLocationNormalizedLoaded) {
            if (view.meta?.noTagsView) return
            if (this.visitedViews.some(v => v.path === view.path)) return

            this.visitedViews.push(view)
        },

        /** 新增 cache（增量） */
        addCachedView(view: RouteLocationNormalizedLoaded) {
            if (view.meta?.noCache) return
            if (!view.name) return

            this.cachedViews.add(view.name as string)
        },

        /** 删除指定 tab + cache */
        delView(view: RouteLocationNormalizedLoaded) {
            this.delVisitedView(view)
            this.delCachedView(view)
        },

        /** 删除 tab */
        delVisitedView(view: RouteLocationNormalizedLoaded) {
            this.visitedViews = this.visitedViews.filter(v => v.path !== view.path)
        },

        /** 删除 cache */
        delCachedView(view?: RouteLocationNormalizedLoaded) {
            const v = view ?? router.currentRoute.value
            if (!v.name) return

            this.cachedViews.delete(v.name as string)
        },

        /** 删除所有（保留 affix） */
        delAllViews() {
            this.visitedViews = this.visitedViews.filter(v => v.meta?.affix)
            this.cachedViews.clear()
        },

        /** 删除其它 */
        delOthersViews(view: RouteLocationNormalizedLoaded) {
            this.visitedViews = this.visitedViews.filter(v => v.meta?.affix || v.path === view.path)

            this.cachedViews.clear()
            if (!view.meta?.noCache && view.name) {
                this.cachedViews.add(view.name as string)
            }
        },
        /** 刷新页签 */
        async refreshView(view?: RouteLocationNormalizedLoaded) {
            const v = view ?? router.currentRoute.value
            if (!v.name || v.meta?.noCache) return

            const name = v.name as string
            this.cachedViews.delete(name)
            await nextTick()
            this.cachedViews.add(name)
        }
    },
    persist: [
        {
            pick: ['visitedViews'],
            storage: localStorage
        }
    ]
})
