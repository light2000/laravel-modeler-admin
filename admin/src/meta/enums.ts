import rawEnums from '@/meta/enums.json'
import type { Option } from '@/meta/types'

export const metaEnums = rawEnums satisfies Record<string, Option[]>
