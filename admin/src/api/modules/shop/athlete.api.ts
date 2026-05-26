import type { paths } from '@/api/types/api';
import { createCrud, QueryParams , ResponseData, Rows, RequestBody} from '@/api/core/crud'
export type AthleteSearchParams = QueryParams<paths['/administrator/shop/athletes']['get']>;
export type AthleteDetail = ResponseData<paths['/administrator/shop/athletes/{athlete}']['get']>;
export type AthleteEdit = ResponseData<paths['/administrator/shop/athletes/{athlete}/edit']['get']>;

export type AthleteCreate = RequestBody<paths['/administrator/shop/athletes']['post']>;

export type AthleteUpdate = RequestBody<paths['/administrator/shop/athletes/{athlete}']['put']>;
export type AthleteListItem = Rows<ResponseData<paths['/administrator/shop/athletes']['get']>>[number];

export const athleteApi = createCrud('/administrator/shop/athletes', { module: 'shop', model: 'athlete' })

export type AthleteApi = typeof athleteApi;
