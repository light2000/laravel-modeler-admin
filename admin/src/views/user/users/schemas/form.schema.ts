import type { FormSchemaItem } from '@/components/PopupForm/types'
import type { UserCreate, UserUpdate } from '@/api/modules/user/user.api';
import { getOptions } from '@/meta/enums.utils';
import type { FormMode } from '@/composables/crud/types';

export const userFormSchema: FormSchemaItem<UserCreate&UserUpdate>[] = [
  {
    prop: 'username',
    label: '账号',
    component: 'input',
    required: true,
  },
  {
    prop: 'password',
    label: '密码',
    component: 'password',
    required: true,
    hidden: (mode: FormMode) => mode == "update"
  },
  {
    prop: 'nickname',
    label: '昵称',
    component: 'input',
    required: true,
  },
  {
    prop: 'avatar',
    label: '头像',
    component: 'upload',
    uploadType: 'image',
    required: true,
  },
  {
    prop: 'status',
    label: '用户状态',
    component: 'select',
    options: getOptions('user_status'),
  },
]