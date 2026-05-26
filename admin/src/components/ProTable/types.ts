import type { Option } from '@/meta/types'

type DataProp<R> = Exclude<keyof R & string, 'operation'>

type CommonColumnProps = {
    label: string
    /** Element Plus 列宽 */
    width?: number
    minWidth?: number
    sortable?: boolean
    /**
     * 使用 slot 自定义渲染。存在 slot 时，表格不会走内置渲染逻辑。
     */
    slot?: string
}

interface BaseDataColumn<R> extends CommonColumnProps {
    prop: DataProp<R>
}

/**
 * - `type` 只表达“数据类型”
 * - `render` 只表达“展示方式”
 */
export interface TextColumn<R> extends BaseDataColumn<R> {
    type: 'text'
    render?: 'text' | 'tag'
}

export interface BooleanColumn<R> extends BaseDataColumn<R> {
    type: 'boolean'
    render?: 'text' | 'tag' | 'switch'
    trueLabel?: string
    falseLabel?: string
}

type EnumSource = { options: Option[]; enumKey?: never } | { enumKey: string; options?: never }

export type EnumColumn<R> = BaseDataColumn<R> &
    EnumSource & {
        type: 'enum'
        render?: 'text' | 'tag'
        /**
         * 多选枚举（值为数组）显式声明。
         * - true：表格展示会按数组逐个映射为 label（可用 tag 渲染）。
         * - false/undefined：按单值枚举展示。
         */
        multiple?: boolean
        /**
         * 多选枚举在 render=text 时的分隔符，默认 ', '。
         * 为了可预测性：不做隐式拆分（如 CSV 字符串），后端/Schema 应产出数组。
         */
        separator?: string
    }

export interface ImageColumn<R> extends BaseDataColumn<R> {
    type: 'image'
    /** 缩略图尺寸（不是列宽），默认 40 */
    size?: number
    /** 是否支持预览，默认 true */
    preview?: boolean
}

export interface ImagesColumn<R> extends BaseDataColumn<R> {
    type: 'images'
    /** 单行最多展示多少张，默认 3 */
    max?: number
    /** 缩略图尺寸（不是列宽），默认 40 */
    size?: number
    /** 是否支持预览，默认 true */
    preview?: boolean
    /** 空值文案，默认 '-' */
    emptyText?: string
}

export interface AvatarColumn<R> extends BaseDataColumn<R> {
    type: 'avatar'
    /** 缩略图尺寸（不是列宽），默认 40 */
    size?: number
    shape?: 'circle' | 'square'
}

export interface AvatarsColumn<R> extends BaseDataColumn<R> {
    type: 'avatars'
    /** 单行最多展示多少个，默认 3 */
    max?: number
    /** 缩略图尺寸（不是列宽），默认 40 */
    size?: number
    /** 是否支持预览，默认 true */
    preview?: boolean
    /** 空值文案，默认 '-' */
    emptyText?: string
}

export interface FKColumn<R> extends BaseDataColumn<R> {
    type: 'fk'
    separator?: string
    emptyText?: string
}

export type OperationColumn = CommonColumnProps & {
    prop: 'operation'
    /**
     * v1 强约束：operation 列只能通过 slot 渲染，避免误用导致运行期才暴露问题。
     * 建议 slot 命名为 'operation'，与 prop 保持一致。
     */
    slot: string
}

export type TableColumn<R> =
    | TextColumn<R>
    | BooleanColumn<R>
    | EnumColumn<R>
    | ImageColumn<R>
    | ImagesColumn<R>
    | AvatarColumn<R>
    | AvatarsColumn<R>
    | FKColumn<R>
    | OperationColumn
