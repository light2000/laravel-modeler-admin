import type { DetailSchemaItem } from '@/components/PopupDetail/types'
import type { AthleteDetail } from '@/api/modules/shop/athlete.api';

export const athleteDetailSchema: DetailSchemaItem<AthleteDetail>[] = [
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
    render: 'tag'
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
    prop: 'birthday',
    type: 'text',
    label: '出生日期'
  },
  {
    prop: 'avatar',
    type: 'avatar',
    label: '头像'
  },
]
