import http from './client'

import type { paths } from '@/api/types/api'

export type Json<T> = T extends { content: { 'application/json': infer R } } ? R : never

export type Response200<P> = P extends { responses: { 200: infer R } } ? Json<R> : never

export type RequestBody<P> = P extends { requestBody?: infer R } ? Json<R> : never

export type QueryParams<P> = P extends { parameters: { query?: infer Q } } ? Q : never

export type Data<T> = T extends { data?: infer D } ? D : never

export type Rows<T> = T extends { rows?: infer D } ? D : never

export type Total<T> = T extends { total?: infer D } ? D : never

export type ResponseData<P> = Data<Response200<P>>

type Param = string

export type Meta = { module: string; model: string }
/**
 * 通用 CRUD 接口
 * @param resource e.g. '/users'
 */
export function createCrud<Resource extends keyof paths>(resource: Resource, meta: Meta) {
    type ItemPath<Resource extends string> = `${Resource}/{${Param}}`
    type EditPath<Resource extends string> = `${Resource}/{${Param}}/edit`
    type ItemResource = ItemPath<Resource> & keyof paths
    type EditResource = EditPath<Resource> & keyof paths
    type SearchParams = QueryParams<paths[Resource]['get']>
    type ListRes = ResponseData<paths[Resource]['get']>
    type DetailRes = ResponseData<paths[ItemResource]['get']>
    type EditRes = ResponseData<paths[EditResource]['get']>
    type CreateBody = RequestBody<paths[Resource]['post']>
    type CreateRes = ResponseData<paths[Resource]['post']>
    type UpdateBody = RequestBody<paths[ItemResource]['put']>
    type UpdateRes = ResponseData<paths[ItemResource]['put']>

    return {
        meta,

        /**
         * 列表
         */
        list(params: SearchParams) {
            return http.get<ListRes, ListRes>(resource, { params })
        },

        /**
         * 新增
         */
        create(data: CreateBody) {
            return http.post<CreateRes, CreateRes>(resource, data)
        },

        /**
         * 详情
         */
        detail(id: string) {
            return http.get<DetailRes, DetailRes>(`${resource}/${id}`)
        },

        /**
         * 获取编辑数据
         * @param id
         */
        edit(id: string) {
            return http.get<EditRes, EditRes>(`${resource}/${id}/edit`)
        },
        /**
         * 更新
         */
        update(id: string, data: UpdateBody) {
            return http.put<UpdateRes, UpdateRes>(`${resource}/${id}`, data)
        },

        /**
         * 删除
         */
        remove(id: string) {
            return http.delete<void, void>(`${resource}/${id}`)
        }
    }
}

export function createUpdateAction<Resource extends keyof paths>(resource: Resource, meta: Meta) {
    type UpdateBody = RequestBody<paths[Resource]['put']>
    type UpdateRow = ResponseData<paths[Resource]['get']>

    return {
        meta,
        /**
         * 获取编辑数据
         * @param id
         */
        edit(id: string) {
            return http.get<UpdateRow, UpdateRow>(resource.replace(`{${meta.model}}`, id.toString()))
        },
        /**
         * 更新
         * @param id
         * @param data
         */
        update(id: string, data: UpdateBody) {
            return http.put<UpdateBody, UpdateBody>(resource.replace(`{${meta.model}}`, id.toString()), data)
        }
    }
}
