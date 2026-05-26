import axios, { AxiosError, AxiosInstance } from 'axios'
import { useAuthStore } from '@/store/modules/auth'

export class ValidationError extends Error {
    status = 422
    body: Record<string, string[]> = {}

    constructor(message: string, status: number, body: Record<string, string[]>) {
        super(message)
        this.name = this.constructor.name
        if (typeof Error.captureStackTrace === 'function') {
            Error.captureStackTrace(this, this.constructor)
        } else {
            this.stack = new Error(message).stack
        }
        this.status = status
        this.body = body
    }
}
/**
 * 创建 axios 实例
 */
const http: AxiosInstance = axios.create({
    baseURL: import.meta.env.VITE_API_BASE_URL,
    timeout: import.meta.env.VITE_APP_HTTP_TIMEOUT as number,
    headers: {
        'Content-Type': 'application/json'
    }
})

/**
 * 请求拦截：注入 token
 */
http.interceptors.request.use(
    config => {
        const auth = useAuthStore()
        if (auth.token) {
            config.headers = config.headers || {}
            config.headers.Authorization = `Bearer ${auth.token}`
        }
        return config
    },
    error => Promise.reject(error)
)

/**
 * 响应拦截：统一解包 / 错误兜底
 */
http.interceptors.response.use(
    response => {
        const res = response.data

        // 后端 success = false
        if (res && res.success === false) {
            return Promise.reject(new Error(res.message || 'Request failed'))
        }

        // 成功：只返回 data，简化上层调用
        return res?.data ?? res
    },
    (error: AxiosError) => {
        // 网络错误 / 超时
        if (!error.response) {
            return Promise.reject(new Error('Network error'))
        }

        const { status, data } = error.response as {
            status: number
            data?: { message?: string; errors?: Record<string, string[]> }
        }

        // 未授权：统一登出
        if (status === 401) {
            const auth = useAuthStore()
            auth.logout()
        }

        // 验证错误
        if (status === 422) {
            return Promise.reject(new ValidationError(data?.message || 'Validation error', status, data?.errors || {}))
        }

        return Promise.reject(new Error(data?.message || `HTTP Error: ${status}`))
    }
)

export default http
