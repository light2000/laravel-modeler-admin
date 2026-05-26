import type { FormSchemaItem } from '@/components/PopupForm/types'
import type { AthleteCreate, AthleteUpdate } from '@/api/modules/shop/athlete.api';
import { getOptions } from '@/meta/enums.utils';

export const athleteFormSchema: FormSchemaItem<AthleteCreate & AthleteUpdate>[] = [
  {
    prop: 'name',
    label: '姓名',
    component: 'input',
    required: true,
  },
  {
    prop: 'gender',
    label: '性别',
    component: 'select',
    options: getOptions('gender'),
  },
  {
    prop: 'height',
    label: '身高',
    component: 'number',
  },
  {
    prop: 'weight',
    label: '体重',
    component: 'number',
  },
  {
    prop: 'birthday',
    label: '出生日期',
    component: 'date',
  },
  {
    prop: 'avatar',
    label: '头像',
    component: 'upload',
    uploadType: 'image',
  },
]
