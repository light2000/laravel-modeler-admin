import type { FormSchemaItem } from '@/components/PopupForm/types'
import type { CategoryCreate, CategoryUpdate } from '@/api/modules/shop/category.api';

export const categoryFormSchema: FormSchemaItem<CategoryCreate & CategoryUpdate>[] = [
  {
    prop: 'name',
    label: '分类名称',
    component: 'input',
    required: true,
  },
  {
    prop: 'parent_id',
    label: '父分类',
    component: 'fk_select',
    model: 'category',
    relationModule: 'shop',
    relationModel: 'category',
  },
  {
    prop: 'sort_order',
    label: '排序',
    component: 'number',
    required: true,
  },
  {
    prop: 'icon',
    label: '图标',
    component: 'upload',
    uploadType: 'image',
  },
]
