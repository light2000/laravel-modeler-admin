import type { ThemeType } from '@/composables/web/types'

export const asideTheme: Record<ThemeType, { [key: string]: string }> = {
    light: {
        '--el-aside-logo-text-color': '#303133',
        '--el-aside-border-color': '#e4e7ed'
    },
    dark: {
        '--el-aside-logo-text-color': '#dadada',
        '--el-aside-border-color': '#414243'
    }
}
