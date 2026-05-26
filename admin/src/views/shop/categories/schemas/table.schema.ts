import type { TableColumn } from '@/components/ProTable/types'
import type { CategoryListItem } from '@/api/modules/shop/category.api'

export const categoryTableSchema: TableColumn<CategoryListItem>[] = [
  {
    prop: 'name',
    type: 'text',
    label: '分类名称'
  },
  {
    prop: 'parent_id',
    type: 'fk',
    label: '父分类'
  },
  {
    prop: 'sort_order',
    type: 'text',
    label: '排序'
  },
  {
    prop: 'icon',
    type: 'image',
    label: '图标',
    minWidth: 66
  },
  {
    prop: 'operation',
    label: '操作',
    width: 240,
    slot: 'operation'
  }
]
