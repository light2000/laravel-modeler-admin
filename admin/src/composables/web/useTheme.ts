import { storeToRefs } from 'pinia'
import { useAppStore } from '@/store/modules/app'
import { menuTheme } from '@/styles/theme/menu'
import { asideTheme } from '@/styles/theme/aside'
import { headerTheme } from '@/styles/theme/header'
import type { ThemeType } from './types'

/**
 * @description hex颜色转rgb颜色
 * @param {String} str 颜色值字符串
 * @returns {Number[]} 返回处理后的颜色值数组 [r, g, b]
 */
function hexToRgb(str: string): number[] {
    const cleaned = str.replace('#', '')
    const hexs = cleaned.match(/../g)
    if (!hexs || hexs.length !== 3) {
        throw new Error('Invalid hex color format')
    }
    return hexs.map(hex => parseInt(hex, 16))
}

/**
 * @description rgb颜色转Hex颜色
 * @param {Number} r 代表红色
 * @param {Number} g 代表绿色
 * @param {Number} b 代表蓝色
 * @returns {String} 返回处理后的颜色值
 */
function rgbToHex(r: number, g: number, b: number): string {
    const hexs = [r.toString(16), g.toString(16), b.toString(16)]
    for (let i = 0; i < 3; i++) {
        if (hexs[i].length === 1) {
            hexs[i] = `0${hexs[i]}`
        }
    }
    return `#${hexs.join('')}`
}

/**
 * @description 加深颜色值
 * @param {String} color 颜色值字符串
 * @param {Number} level 加深的程度，限0-1之间
 * @returns {String} 返回处理后的颜色值
 */
function getDarkColor(color: string, level: number) {
    const rgb = hexToRgb(color)
    for (let i = 0; i < 3; i++) {
        rgb[i] = Math.round(20.5 * level + rgb[i] * (1 - level))
    }
    return rgbToHex(rgb[0], rgb[1], rgb[2])
}

/**
 * @description 变浅颜色值
 * @param {String} color 颜色值字符串
 * @param {Number} level 加深的程度，限0-1之间
 * @returns {String} 返回处理后的颜色值
 */
function getLightColor(color: string, level: number) {
    const rgb = hexToRgb(color)
    for (let i = 0; i < 3; i++) {
        rgb[i] = Math.round(255 * level + rgb[i] * (1 - level))
    }
    return rgbToHex(rgb[0], rgb[1], rgb[2])
}

/**
 * @description 全局主题 hooks
 * */
export const useTheme = () => {
    const appStore = useAppStore()
    const { primary, dark } = storeToRefs(appStore)

    // 切换暗黑模式 ==> 并带修改主题颜色、侧边栏、头部颜色
    const switchDark = () => {
        const html = document.documentElement
        html.setAttribute('class', dark.value ? 'dark' : '')
        changePrimary(primary.value)
        setAsideTheme()
        setHeaderTheme()
    }

    // 修改主题颜色
    const changePrimary = (val: string) => {
        // 计算主题颜色变化
        document.documentElement.style.setProperty('--el-color-primary', val)
        document.documentElement.style.setProperty(
            '--el-color-primary-dark-2',
            dark.value ? `${getLightColor(val, 0.2)}` : `${getDarkColor(val, 0.3)}`
        )
        for (let i = 1; i <= 9; i++) {
            const primaryColor = dark.value ? `${getDarkColor(val, i / 10)}` : `${getLightColor(val, i / 10)}`
            document.documentElement.style.setProperty(`--el-color-primary-light-${i}`, primaryColor)
        }
        appStore.setPrimary(val)
    }

    // 设置菜单样式
    const setMenuTheme = () => {
        let type: ThemeType = 'light'
        if (dark.value) type = 'dark'
        const theme = menuTheme[type]
        for (const [key, value] of Object.entries(theme)) {
            document.documentElement.style.setProperty(key, value)
        }
    }

    // 设置侧边栏样式
    const setAsideTheme = () => {
        let type: ThemeType = 'light'
        if (dark.value) type = 'dark'
        const theme = asideTheme[type]
        for (const [key, value] of Object.entries(theme)) {
            document.documentElement.style.setProperty(key, value)
        }
        setMenuTheme()
    }

    // 设置头部样式
    const setHeaderTheme = () => {
        let type: ThemeType = 'light'
        if (dark.value) type = 'dark'
        const theme = headerTheme[type]
        for (const [key, value] of Object.entries(theme)) {
            document.documentElement.style.setProperty(key, value)
        }
        setMenuTheme()
    }

    // init theme
    const initTheme = () => {
        switchDark()
    }

    return {
        initTheme,
        switchDark,
        changePrimary,
        setAsideTheme,
        setHeaderTheme
    }
}
