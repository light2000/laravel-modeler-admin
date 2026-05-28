import type { TableColumn } from '@/components/ProTable/types'
import type { UserListItem } from '@/api/modules/user/user.api'

export const userTableSchema: TableColumn<UserListItem>[] = [
  {
    prop: 'username',
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
    prop: 'status',
    type: 'enum',
    label: '用户状态',
    enumKey: 'user_status',
    render: 'tag',
    minWidth: 100
  },
  {
    prop: 'operation',
    label: '操作',
    width: 240,
    slot: 'operation'
  }
]