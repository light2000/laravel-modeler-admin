import type { TableColumn } from '@/components/ProTable/types'
import type { AdministratorListItem } from '@/api/modules/user/administrator.api'

export const administratorTableSchema: TableColumn<AdministratorListItem>[] = [
  {
    prop: 'account',
    type: 'text',
    label: '账号'
  },
  {
    prop: 'nickname',
    type: 'text',
    label: '昵称'
  },
  {
    prop: 'avatar',
    type: 'avatar',
    label: '头像',
    minWidth: 66
  },
  {
    prop: 'operation',
    label: '操作',
    width: 160,
    slot: 'operation'
  }
]