import type { paths } from '@/api/types/api';
import { createCrud, QueryParams , ResponseData, Rows, RequestBody} from '@/api/core/crud'
export type CategorySearchParams = QueryParams<paths['/administrator/shop/categories']['get']>;
export type CategoryDetail = ResponseData<paths['/administrator/shop/categories/{category}']['get']>;
export type CategoryEdit = ResponseData<paths['/administrator/shop/categories/{category}/edit']['get']>;

export type CategoryCreate = RequestBody<paths['/administrator/shop/categories']['post']>;

export type CategoryUpdate = RequestBody<paths['/administrator/shop/categories/{category}']['put']>;
export type CategoryListItem = Rows<ResponseData<paths['/administrator/shop/categories']['get']>>[number];

export const categoryApi = createCrud('/administrator/shop/categories', { module: 'shop', model: 'category' })

export type CategoryApi = typeof categoryApi;
