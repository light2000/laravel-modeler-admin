import type { Option } from '@/meta/types'

export const SEARCH_COMPONENT_BY_TYPE = {
    text: 'input',
    enum: 'select',
    number: 'number',
    date: 'date',
    daterange: 'daterange',
    numberrange: 'numberrange',
    fk: 'fk'
} as const

export type SearchFieldType = keyof typeof SEARCH_COMPONENT_BY_TYPE
export type SearchComponent = (typeof SEARCH_COMPONENT_BY_TYPE)[SearchFieldType]

export function resolveSearchComponent(type: SearchFieldType): SearchComponent {
    return SEARCH_COMPONENT_BY_TYPE[type]
}

type BaseSearchColumn = {
    prop: string
    label: string
}

type RangeMap<T> = {
    from: keyof T & string
    to: keyof T & string
}

type EnumSource = { options: Option[]; enumKey?: never } | { enumKey: string; options?: never }

export type SearchColumn<T> =
    | (BaseSearchColumn & {
          type: 'text'
          prop: keyof T & string
          defaultValue?: string
      })
    | (BaseSearchColumn & {
          type: 'number'
          prop: keyof T & string
          defaultValue?: number
      })
    | (BaseSearchColumn & {
          type: 'numberrange'
          prop: string
          map: RangeMap<T>
          /** [min, max]；允许只填一侧 */
          defaultValue?: [number | undefined, number | undefined]
      })
    | (BaseSearchColumn &
          EnumSource & {
              type: 'enum'
              prop: keyof T & string
              defaultValue?: Option['value']
          })
    | (BaseSearchColumn & {
          type: 'date'
          prop: keyof T & string
          /** value-format 固定为 YYYY-MM-DD */
          defaultValue?: string
      })
    | (BaseSearchColumn & {
          type: 'daterange'
          prop: string
          map: RangeMap<T>
          /** [start, end]；允许只填一侧 */
          defaultValue?: [string | undefined, string | undefined]
      })
    | (BaseSearchColumn & {
          type: 'yearrange'
          prop: string
          map: RangeMap<T>
          /** [start, end]；允许只填一侧 */
          defaultValue?: [string | undefined, string | undefined]
      })
    | (BaseSearchColumn & {
          type: 'fk'
          prop: keyof T & string
          /** 当前搜索表单所属的模型名，例如：'product' */
          model: string
          /** 关联模型所属的模块名，例如：'shop' */
          relationModule: string
          /** 关联模型名，例如：'category' */
          relationModel: string
          defaultValue?: number | string
      })
    | (BaseSearchColumn & {
          type: 'boolean'
          prop: keyof T & string
          defaultValue?: boolean
      })
