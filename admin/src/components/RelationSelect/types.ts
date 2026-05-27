import type { Option } from '@/meta/types'

export interface RelationSelectProps {
    /** 关联字段名，例如：'product.supplier_id' 或 'product.supplier_type' */
    field: string
    /** 关联模型所属的模块名，例如：'shop'（新参数，用于普通FK API URL） */
    relationModule?: string
    /** 关联模型名，例如：'category'（新参数，用于普通FK API URL） */
    relationModel?: string
    /** 是否为多态关系 */
    polymorphic?: boolean
    /** 是否可清空 */
    clearable?: boolean
    /** 占位符 */
    placeholder?: string
    /** 是否禁用 */
    disabled?: boolean
    /** 是否多选 */
    multiple?: boolean
}

export interface PolymorphicTypes {
    [key: string]: Option[]
}
