import type { Meta } from '@/api/core/crud'
export type FormMode = 'create' | 'update'

export interface BaseQuery {
    page?: number | null
    page_size?: '10' | '25' | '50' | '100' | null
    sort?: string | null
}

export interface CrudApi<Row, Detail, FormRow, Query extends BaseQuery, CreateForm, UpdateForm> {
    meta: Meta
    list(params: Query): Promise<{ rows: Row[]; total: number }>
    create(data: CreateForm): Promise<FormRow>
    detail(id: string): Promise<Detail>
    edit(id: string): Promise<FormRow>
    update(id: string, data: UpdateForm): Promise<FormRow>
    remove(id: string | (string | number)[]): Promise<void>
}
