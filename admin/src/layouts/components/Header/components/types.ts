import type { Placement } from 'element-plus'

export interface ButtonIconProps {
    /** Iconify icon name */
    icon?: string
    /** Tooltip content */
    tooltipContent?: string
    /** Tooltip placement */
    tooltipPlacement?: Placement
    zIndex?: number
}
