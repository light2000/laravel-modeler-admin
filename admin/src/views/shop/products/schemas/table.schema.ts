import type { TableColumn } from '@/components/ProTable/types'
import type { ProductListItem } from '@/api/modules/shop/product.api'

export const productTableSchema: TableColumn<ProductListItem>[] = [
  {
    prop: 'name',
    type: 'text',
    label: '产品名称'
  },
  {
    prop: 'price',
    type: 'text',
    label: '价格'
  },
  {
    prop: 'stock',
    type: 'text',
    label: '库存'
  },
  {
    prop: 'category_id',
    type: 'fk',
    label: '分类'
  },
  {
    prop: 'status',
    type: 'enum',
    label: '产品状态',
    enumKey: 'product_status',
    render: 'tag',
    minWidth: 100
  },
  {
    prop: 'cover_image',
    type: 'image',
    label: '封面图',
    minWidth: 66
  },
  {
    prop: 'free_shipping',
    type: 'boolean',
    label: '包邮',
    render: 'tag'
  },
  {
    prop: 'operation',
    label: '操作',
    width: 240,
    slot: 'operation'
  }
]
