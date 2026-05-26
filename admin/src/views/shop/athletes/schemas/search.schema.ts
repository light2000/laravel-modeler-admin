import type { SearchColumn } from '@/components/SearchForm/types'
import type { AthleteSearchParams } from '@/api/modules/shop/athlete.api';
import { getOptions } from '@/meta/enums.utils';

export const athleteSearchSchema: SearchColumn<AthleteSearchParams>[] = [
  {
    prop: 'name',
    label: '姓名',
    type: 'text'
  },
  {
    prop: 'gender',
    label: '性别',
    type: 'enum',
    options: getOptions('gender'),
  },
]
