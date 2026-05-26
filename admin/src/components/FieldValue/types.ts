import type { Option } from '@/meta/types'

/**
 * FieldValue 组件支持的字段配置类型
 * 基于 TableColumn 但更通用，可用于表格和详情页
 */
// eslint-disable-next-line @typescript-eslint/no-explicit-any
export type FieldConfig<R = any> =
    | RichTextFieldConfig<R>
    | TextFieldConfig<R>
    | BooleanFieldConfig<R>
    | EnumFieldConfig<R>
    | ImageFieldConfig<R>
    | ImagesFieldConfig<R>
    | AvatarFieldConfig<R>
    | AvatarsFieldConfig<R>
    | FKFieldConfig<R>

export interface RichTextFieldConfig<R> {
    type: 'rich-text'
    prop: keyof R & string
}

export interface TextFieldConfig<R> {
    type: 'text'
    prop: keyof R & string
    render?: 'text' | 'tag'
}

export interface BooleanFieldConfig<R> {
    type: 'boolean'
    prop: keyof R & string
    render?: 'text' | 'tag' | 'switch'
    trueLabel?: string
    falseLabel?: string
}

type EnumSource = { options: Option[]; enumKey?: never } | { enumKey: string; options?: never }

export type EnumFieldConfig<R> = EnumSource & {
    type: 'enum'
    prop: keyof R & string
    render?: 'text' | 'tag'
    multiple?: boolean
    separator?: string
}

export interface ImageFieldConfig<R> {
    type: 'image'
    prop: keyof R & string
    size?: number
    preview?: boolean
}

export interface ImagesFieldConfig<R> {
    type: 'images'
    prop: keyof R & string
    max?: number
    size?: number
    preview?: boolean
    emptyText?: string
}

export interface AvatarFieldConfig<R> {
    type: 'avatar'
    prop: keyof R & string
    size?: number
    shape?: 'circle' | 'square'
}

export interface AvatarsFieldConfig<R> {
    type: 'avatars'
    prop: keyof R & string
    max?: number
    size?: number
    preview?: boolean
    emptyText?: string
}

export interface FKFieldConfig<R> {
    type: 'fk'
    prop: keyof R & string
    separator?: string
    emptyText?: string
}
