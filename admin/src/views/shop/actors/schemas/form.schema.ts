import type { FormSchemaItem } from '@/components/PopupForm/types'
import type { ActorCreate, ActorUpdate } from '@/api/modules/shop/actor.api';
import { getOptions } from '@/meta/enums.utils';

export const actorFormSchema: FormSchemaItem<ActorCreate & ActorUpdate>[] = [
  {
    prop: 'name',
    label: '演员名称',
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
    prop: 'birth_date',
    label: '出生日期',
    component: 'date',
  },
  {
    prop: 'nationality',
    label: '国籍',
    component: 'input',
  },
  {
    prop: 'avatar',
    label: '头像',
    component: 'upload',
    uploadType: 'image',
  },
  {
    prop: 'biography',
    label: '简介',
    component: 'textarea',
  },
]
