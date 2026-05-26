import type { DetailSchemaItem } from '@/components/PopupDetail/types'
import type { UserDetail } from '@/api/modules/user/user.api';

export const userDetailSchema: DetailSchemaItem<UserDetail>[] = [
      {
        prop: 'username',
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
      {
        prop: 'status',
        type: 'enum',
        label: '用户状态',
        enumKey: 'user_status',
        render: 'tag'
      },
]