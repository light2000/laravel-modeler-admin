import type { SearchColumn } from '@/components/SearchForm/types'
import type { ProductSearchParams } from '@/api/modules/shop/product.api';
import { getOptions } from '@/meta/enums.utils';

export const productSearchSchema: SearchColumn<ProductSearchParams>[] = [
  {
    prop: 'name',
    label: '产品名称',
    type: 'text'
  },
  {
    prop: 'category_id',
    label: '分类',
    type: 'fk',
    model: 'product',
    relationModule: 'shop',
    relationModel: 'category',
  },
  {
    prop: 'status',
    label: '产品状态',
    type: 'enum',
    options: getOptions('product_status'),
  },
  {
    prop: 'free_shipping',
    label: '包邮',
    type: 'boolean',
  },
]
