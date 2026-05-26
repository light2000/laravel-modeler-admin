import type { paths } from '@/api/types/api';
import { createCrud, QueryParams , ResponseData, Rows, RequestBody} from '@/api/core/crud'
export type ProductSearchParams = QueryParams<paths['/administrator/shop/products']['get']>;
export type ProductDetail = ResponseData<paths['/administrator/shop/products/{product}']['get']>;
export type ProductEdit = ResponseData<paths['/administrator/shop/products/{product}/edit']['get']>;

export type ProductCreate = RequestBody<paths['/administrator/shop/products']['post']>;

export type ProductUpdate = RequestBody<paths['/administrator/shop/products/{product}']['put']>;
export type ProductListItem = Rows<ResponseData<paths['/administrator/shop/products']['get']>>[number];

export const productApi = createCrud('/administrator/shop/products', { module: 'shop', model: 'product' })

export type ProductApi = typeof productApi;
