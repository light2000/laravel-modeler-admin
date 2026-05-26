import type { SearchColumn } from '@/components/SearchForm/types'
import type { ActorSearchParams } from '@/api/modules/shop/actor.api';
import { getOptions } from '@/meta/enums.utils';

export const actorSearchSchema: SearchColumn<ActorSearchParams>[] = [
  {
    prop: 'name',
    label: '演员名称',
    type: 'text'
  },
  {
    prop: 'gender',
    label: '性别',
    type: 'enum',
    options: getOptions('gender'),
  },
  {
    prop: 'nationality',
    label: '国籍',
    type: 'text'
  },
]
