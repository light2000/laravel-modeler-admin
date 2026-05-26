/* eslint-disable @typescript-eslint/no-explicit-any */
import type { FormMode } from '@/composables/crud/types'
import type { Option } from '@/meta/types'

export interface FormSchemaItem<T> {
    prop: (keyof T & string) | string
    label: string
    component:
        | 'input'
        | 'textarea'
        | 'number'
        | 'select'
        | 'switch'
        | 'date'
        | 'datetime'
        | 'time'
        | 'year'
        | 'upload'
        | 'rich-text'
        | 'slot'
        | 'fk_select'
        | 'morph_select'
        | 'password'
    default?: T[keyof T]
    required?: boolean | ((mode: FormMode) => boolean)
    disabled?: boolean | ((mode: FormMode) => boolean)
    hidden?: boolean | ((mode: FormMode) => boolean)
    normalize?: (value: unknown) => unknown
    /** 选项 */
    options?: Option[]

    rules?: any[]
    /** 是否前端虚拟字段（不提交给后端） */
    virtual?: boolean
    /** 组件属性 */
    componentProps?: Record<string, any>
    uploadType?: 'image' | 'file'
    /** 关联模型所属的模块名（用于 fk_select），例如：'shop' */
    relationModule?: string
    /** 关联模型名（用于 fk_select），例如：'category' */
    relationModel?: string
    /** 当前表单所属的模型名（用于 fk_select 和 morph_select），例如：'product' */
    model?: string
}
