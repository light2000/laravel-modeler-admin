import { metaEnums } from './enums'
import type { Option } from './types'

export function getOptions(key: string): Option[] {
    return metaEnums[key] ?? []
}

export function getOptionLabel(options: Option[], value: string | number): string {
    return options.find(option => option.value === value)?.label ?? ''
}
