import { defineStore } from 'pinia'
import { defaultLocale } from '@/settings/locale'

import { DEFAULT_PRIMARY, theme } from '@/settings/theme'
type LayoutType = 'vertical' | 'classic' | 'transverse' | 'columns'

interface AppState {
    title: string
    locale: string
    primary: string
    dark: boolean
    layout: LayoutType
    collapse: boolean
    tabs: boolean
}

export const useAppStore = defineStore('app', {
    state: (): AppState => {
        return {
            title: import.meta.env.VITE_APP_NAME, // 标题
            locale: defaultLocale, // 语言
            primary: DEFAULT_PRIMARY, // 主题色
            dark: false, // 是否暗黑模式
            layout: 'vertical', // layout布局
            collapse: false, //折叠菜单
            tabs: true // 标签页
        }
    },
    actions: {
        setTitle(title: string) {
            this.title = title
        },
        setLocale(locale: string) {
            this.locale = locale
        },
        setPrimary(primary: string) {
            this.primary = primary
        },
        setDark(dark: boolean) {
            this.dark = dark
        },
        setLayout(layout: LayoutType) {
            this.layout = layout
        },
        setCollapse(collapse: boolean) {
            this.collapse = collapse
        },
        setTabs(tabs: boolean) {
            this.tabs = tabs
        },
        switchPrimary() {
            let index = theme.colorList.indexOf(this.primary) + 1
            if (index >= theme.colorList.length) {
                index = 0
            }
            this.primary = theme.colorList[index]
        },
        switchLayout() {
            let index = theme.layoutList.indexOf(this.layout) + 1
            if (index >= theme.layoutList.length) {
                index = 0
            }
            this.layout = theme.layoutList[index] as LayoutType
        }
    },
    persist: true
})
