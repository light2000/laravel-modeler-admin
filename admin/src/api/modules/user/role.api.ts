import type { paths } from '@/api/types/api'
import { createCrud, QueryParams, ResponseData, Rows, RequestBody } from '@/api/core/crud'
import { createUpdateAction } from '@/api/core/crud'

export type RoleSearchParams = QueryParams<paths['/administrator/user/roles']['get']>
export type RoleDetail = ResponseData<paths['/administrator/user/roles/{role}']['get']>
export type RoleEdit = ResponseData<paths['/administrator/user/roles/{role}/edit']['get']>
export type RoleCreate = RequestBody<paths['/administrator/user/roles']['post']>
export type RoleUpdate = RequestBody<paths['/administrator/user/roles/{role}']['put']>
export type RoleListItem = Rows<ResponseData<paths['/administrator/user/roles']['get']>>[number]
export const roleApi = createCrud('/administrator/user/roles', { module: 'user', model: 'role' })
export type RoleApi = typeof roleApi
export type RolePermissionsEdit = ResponseData<paths['/administrator/user/roles/{role}/permissions']['get']>
export type RolePermissionsUpdate = RequestBody<paths['/administrator/user/roles/{role}/permissions']['put']>
export const rolePermissionsAction = createUpdateAction('/administrator/user/roles/{role}/permissions', {
    module: 'user',
    model: 'role'
})
export type RolePermissionsAction = typeof rolePermissionsAction
