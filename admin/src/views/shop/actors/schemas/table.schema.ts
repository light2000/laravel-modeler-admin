import type { TableColumn } from '@/components/ProTable/types'
import type { ActorListItem } from '@/api/modules/shop/actor.api'

export const actorTableSchema: TableColumn<ActorListItem>[] = [
  {
    prop: 'name',
    type: 'text',
    label: '演员名称'
  },
  {
    prop: 'gender',
    type: 'enum',
    label: '性别',
    enumKey: 'gender',
    render: 'tag',
    minWidth: 80
  },
  {
    prop: 'nationality',
    type: 'text',
    label: '国籍'
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
    width: 240,
    slot: 'operation'
  }
]
