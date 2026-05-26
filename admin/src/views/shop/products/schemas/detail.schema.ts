import type { DetailSchemaItem } from '@/components/PopupDetail/types'
import type { ProductDetail } from '@/api/modules/shop/product.api';

export const productDetailSchema: DetailSchemaItem<ProductDetail>[] = [
  {
    prop: 'name',
    type: 'text',
    label: '产品名称'
  },
  {
    prop: 'description',
    type: 'text',
    label: '产品描述'
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
    render: 'tag'
  },
  {
    prop: 'photos',
    type: 'images',
    label: '组图'
  },
  {
    prop: 'label',
    type: 'enum',
    label: '标签',
    enumKey: 'product_label',
    multiple: true,
    render: 'tag'
  },
  {
    prop: 'cover_image',
    type: 'image',
    label: '封面图'
  },
  {
    prop: 'free_shipping',
    type: 'boolean',
    label: '包邮',
    render: 'tag'
  },
  {
    prop: 'detailed_information',
    type: 'rich-text',
    label: '详细信息'
  },
  {
    prop: 'on_sale_time',
    type: 'text',
    label: '上架时间'
  },
  {
    prop: 'production_date',
    type: 'text',
    label: '生产日期'
  },
]
