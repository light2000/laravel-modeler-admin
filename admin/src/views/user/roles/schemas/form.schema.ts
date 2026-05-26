import type { FormSchemaItem } from '@/components/PopupForm/types'
import type { RoleCreate, RoleUpdate } from '@/api/modules/user/role.api';

export const roleFormSchema: FormSchemaItem<RoleCreate&RoleUpdate>[] = [
  {
    prop: 'name',
    label: '角色名称',
    component: 'input',
    required: true,
  },
]