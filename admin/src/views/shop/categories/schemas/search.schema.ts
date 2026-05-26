import type { SearchColumn } from '@/components/SearchForm/types'
import type { CategorySearchParams } from '@/api/modules/shop/category.api';

export const categorySearchSchema: SearchColumn<CategorySearchParams>[] = [
  {
    prop: 'name',
    label: '分类名称',
    type: 'text'
  },
  {
    prop: 'parent_id',
    label: '父分类',
    type: 'fk',
    model: 'category',
    relationModule: 'shop',
    relationModel: 'category',
  },
]
