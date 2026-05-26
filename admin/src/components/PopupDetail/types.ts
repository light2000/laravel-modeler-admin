import type { FieldConfig } from '@/components/FieldValue/types'

/**
 * DetailSchemaItem 支持两种模式：
 * 1. 使用 FieldValue 渲染：提供 type 字段
 * 2. 自定义渲染：提供 render 函数或 formatter 函数
 */
export type DetailSchemaItem<T> = FieldConfig<T> & {
    label: string
    span?: number
}
