import type { FormSchemaItem } from '@/components/PopupForm/types'
import type { ProductCreate, ProductUpdate } from '@/api/modules/shop/product.api';
import { getOptions } from '@/meta/enums.utils';

export const productFormSchema: FormSchemaItem<ProductCreate & ProductUpdate>[] = [
  {
    prop: 'name',
    label: '产品名称',
    component: 'input',
    required: true,
  },
  {
    prop: 'description',
    label: '产品描述',
    component: 'textarea',
  },
  {
    prop: 'price',
    label: '价格',
    component: 'number',
    required: true,
  },
  {
    prop: 'stock',
    label: '库存',
    component: 'number',
    required: true,
  },
  {
    prop: 'category_id',
    label: '分类',
    component: 'fk_select',
    model: 'product',
    relationModule: 'shop',
    relationModel: 'category',
    required: true,
  },
  {
    prop: 'status',
    label: '产品状态',
    component: 'select',
    options: getOptions('product_status'),
    required: true,
  },
  {
    prop: 'photos',
    label: '组图',
    component: 'upload',
    uploadType: 'image',
    componentProps: { multiple: true },
  },
  {
    prop: 'label',
    label: '标签',
    component: 'select',
    options: getOptions('product_label'),
    componentProps: { multiple: true },
  },
  {
    prop: 'cover_image',
    label: '封面图',
    component: 'upload',
    uploadType: 'image',
  },
  {
    prop: 'free_shipping',
    label: '包邮',
    component: 'switch',
  },
  {
    prop: 'detailed_information',
    label: '详细信息',
    component: 'rich-text',
  },
  {
    prop: 'on_sale_time',
    label: '上架时间',
    component: 'datetime',
  },
  {
    prop: 'production_date',
    label: '生产日期',
    component: 'date',
  },
  {
    prop: 'spokesperson',
    label: '代言人',
    component: 'morph_select',
    model: 'product',
  },
]
