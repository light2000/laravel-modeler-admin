import type { DetailSchemaItem } from '@/components/PopupDetail/types'
import type { RoleDetail } from '@/api/modules/user/role.api';

export const roleDetailSchema: DetailSchemaItem<RoleDetail>[] = [
      {
        prop: 'name',
        type: 'text',
        label: '角色名称'
      },
]