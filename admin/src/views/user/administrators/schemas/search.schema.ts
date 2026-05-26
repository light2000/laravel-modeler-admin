import type { SearchColumn } from '@/components/SearchForm/types'
import type { AdministratorSearchParams } from '@/api/modules/user/administrator.api';

export const administratorSearchSchema: SearchColumn<AdministratorSearchParams>[] = [
  {
    prop: 'account',
    label: '账号',
    type: 'text'
  },
  {
    prop: 'nickname',
    label: '昵称',
    type: 'text'
  },
]