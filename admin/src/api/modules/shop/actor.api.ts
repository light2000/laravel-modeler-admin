import type { paths } from '@/api/types/api';
import { createCrud, QueryParams , ResponseData, Rows, RequestBody} from '@/api/core/crud'
export type ActorSearchParams = QueryParams<paths['/administrator/shop/actors']['get']>;
export type ActorDetail = ResponseData<paths['/administrator/shop/actors/{actor}']['get']>;
export type ActorEdit = ResponseData<paths['/administrator/shop/actors/{actor}/edit']['get']>;

export type ActorCreate = RequestBody<paths['/administrator/shop/actors']['post']>;

export type ActorUpdate = RequestBody<paths['/administrator/shop/actors/{actor}']['put']>;
export type ActorListItem = Rows<ResponseData<paths['/administrator/shop/actors']['get']>>[number];

export const actorApi = createCrud('/administrator/shop/actors', { module: 'shop', model: 'actor' })

export type ActorApi = typeof actorApi;
