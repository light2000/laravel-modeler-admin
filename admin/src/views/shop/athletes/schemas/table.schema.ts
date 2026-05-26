import type { TableColumn } from '@/components/ProTable/types'
import type { AthleteListItem } from '@/api/modules/shop/athlete.api'

export const athleteTableSchema: TableColumn<AthleteListItem>[] = [
  {
    prop: 'name',
    type: 'text',
    label: '姓名'
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
    prop: 'height',
    type: 'text',
    label: '身高'
  },
  {
    prop: 'weight',
    type: 'text',
    label: '体重'
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
