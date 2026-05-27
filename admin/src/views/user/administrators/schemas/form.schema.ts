import type { FormSchemaItem } from '@/components/PopupForm/types'
import type { AdministratorCreate, AdministratorUpdate } from '@/api/modules/user/administrator.api';
import type { FormMode } from '@/composables/crud/types';

export const administratorFormSchema: FormSchemaItem<AdministratorCreate & AdministratorUpdate>[] = [
  {
    prop: 'account',
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
    prop: 'role_ids',
    label: '角色',
    component: 'fk_select',
    model: 'administrator',
    relationModule: 'user',
    relationModel: 'role',
    componentProps: { multiple: true },
  },
]