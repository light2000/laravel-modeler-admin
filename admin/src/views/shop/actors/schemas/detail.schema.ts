import type { DetailSchemaItem } from '@/components/PopupDetail/types'
import type { ActorDetail } from '@/api/modules/shop/actor.api';

export const actorDetailSchema: DetailSchemaItem<ActorDetail>[] = [
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
    render: 'tag'
  },
  {
    prop: 'birth_date',
    type: 'text',
    label: '出生日期'
  },
  {
    prop: 'nationality',
    type: 'text',
    label: '国籍'
  },
  {
    prop: 'avatar',
    type: 'avatar',
    label: '头像'
  },
  {
    prop: 'biography',
    type: 'text',
    label: '简介'
  },
]
