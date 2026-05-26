import type { DetailSchemaItem } from '@/components/PopupDetail/types'
import type { AdministratorDetail } from '@/api/modules/user/administrator.api';

export const administratorDetailSchema: DetailSchemaItem<AdministratorDetail>[] = [
      {
        prop: 'account',
        type: 'text',
        label: '账号'
      },
      {
        prop: 'nickname',
        type: 'text',
        label: '昵称'
      },
      {
        prop: 'avatar',
        type: 'image',
        label: '头像'
      },
]