
import type { paths } from '@/api/types/api';
import { createCrud, QueryParams , ResponseData, Rows, RequestBody} from '@/api/core/crud'
export type UserSearchParams = QueryParams<paths['/administrator/user/users']['get']>;
export type UserDetail = ResponseData<paths['/administrator/user/users/{user}']['get']>;
export type UserEdit = ResponseData<paths['/administrator/user/users/{user}/edit']['get']>;

export type UserCreate = RequestBody<paths['/administrator/user/users']['post']>;

export type UserUpdate = RequestBody<paths['/administrator/user/users/{user}']['put']>;
export type UserListItem = Rows<ResponseData<paths['/administrator/user/users']['get']>>[number];

export const userApi = createCrud('/administrator/user/users', { module: 'user', model: 'user' })

export type UserApi = typeof userApi;