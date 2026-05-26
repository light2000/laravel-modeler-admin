import { RequestBody, ResponseData } from '@/api/core/crud'
import http from '@/api/core/client'
import { paths } from '@/api/types/api'

export type LoginParams = RequestBody<paths['/auth/administrator/login']['post']>
export type LoginRes = ResponseData<paths['/auth/administrator/login']['post']>
export const loginApi = (params: LoginParams) => {
    return http.post<LoginRes, LoginRes>('/auth/administrator/login', params)
}
export const logoutApi = () => {
    return http.post('/auth/administrator/logout')
}
