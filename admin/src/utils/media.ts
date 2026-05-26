const BASE_URL = import.meta.env.VITE_ASSET_BASE_URL

export function resolveImageUrl(url?: string | null): string | undefined {
    if (!url) return undefined

    // 已是绝对地址
    if (/^https?:\/\//i.test(url)) {
        return url
    }

    // 兼容以 / 开头的相对路径
    if (url.startsWith('/')) {
        return `${BASE_URL}${url}`
    }

    return `${BASE_URL}/${url}`
}
