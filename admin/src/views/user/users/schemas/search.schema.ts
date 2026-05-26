import type { SearchColumn } from '@/components/SearchForm/types'
import type { UserSearchParams } from '@/api/modules/user/user.api';
import { getOptions } from '@/meta/enums.utils';

export const userSearchSchema: SearchColumn<UserSearchParams>[] = [
  {
    prop: 'username',
    label: '账号',
    type: 'text'
  },
  {
    prop: 'nickname',
    label: '昵称',
    type: 'text'
  },
  {
    prop: 'status',
    label: '用户状态',
    type: 'enum',
    options: getOptions('user_status'),
  },
]