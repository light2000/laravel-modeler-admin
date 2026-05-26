import type { paths } from '@/api/types/api'
import { createCrud, QueryParams, ResponseData, Rows, RequestBody, Response200 } from '@/api/core/crud'
import http from '@/api/core/client'

export type AdministratorSearchParams = QueryParams<paths['/administrator/user/administrators']['get']>
export type AdministratorDetail = ResponseData<paths['/administrator/user/administrators/{administrator}']['get']>
export type AdministratorEdit = ResponseData<paths['/administrator/user/administrators/{administrator}/edit']['get']>
export type AdministratorCreate = RequestBody<paths['/administrator/user/administrators']['post']>
export type AdministratorUpdate = RequestBody<paths['/administrator/user/administrators/{administrator}']['put']>
export type AdministratorListItem = Rows<ResponseData<paths['/administrator/user/administrators']['get']>>[number]
export const administratorApi = createCrud('/administrator/user/administrators', {
    module: 'user',
    model: 'administrator'
})
export type AdministratorApi = typeof administratorApi
export type ProfileRes = ResponseData<paths['/administrator/me']['get']>
export type UpdateProfileBody = RequestBody<paths['/administrator/me/profile']['put']>
export type UpdateProfileRes = ResponseData<paths['/administrator/me/profile']['put']>
export type ChangePasswordBody = RequestBody<paths['/administrator/me/password']['put']>
export type ChangePasswordRes = Response200<paths['/administrator/me/password']['put']>
export const meApi = {
    profile() {
        return http.get<ProfileRes, ProfileRes>('/administrator/me')
    },
    updateProfile(data: UpdateProfileBody) {
        return http.put<UpdateProfileRes, UpdateProfileRes>('/administrator/me/profile', data)
    },
    changePassword(data: ChangePasswordBody) {
        return http.put<ChangePasswordRes, ChangePasswordRes>('/administrator/me/password', data)
    }
}
