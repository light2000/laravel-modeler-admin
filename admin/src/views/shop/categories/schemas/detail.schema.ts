import type { DetailSchemaItem } from '@/components/PopupDetail/types'
import type { CategoryDetail } from '@/api/modules/shop/category.api';

export const categoryDetailSchema: DetailSchemaItem<CategoryDetail>[] = [
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
    label: '图标'
  },
]
