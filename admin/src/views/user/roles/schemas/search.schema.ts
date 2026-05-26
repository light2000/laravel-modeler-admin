import type { SearchColumn } from '@/components/SearchForm/types'
import type { RoleSearchParams } from '@/api/modules/user/role.api';

export const roleSearchSchema: SearchColumn<RoleSearchParams>[] = [
  {
    prop: 'name',
    label: '角色名称',
    type: 'text'
  },
]