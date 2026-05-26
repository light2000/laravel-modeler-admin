import type { TableColumn } from '@/components/ProTable/types'
import type { RoleListItem } from '@/api/modules/user/role.api'

export const roleTableSchema: TableColumn<RoleListItem>[] = [
  {
    prop: 'name',
    type: 'text',
    label: '角色名称'
  },
  {
    prop: 'operation',
    label: '操作',
    width: 160,
    slot: 'operation'
  }
]