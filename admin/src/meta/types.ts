export interface Option {
    value: string | number
    label: string
}

export interface PermissionAction {
    key: string
    label: string
}

export interface PermissionModel {
    key: string
    label: string
    actions?: PermissionAction[]
}

export interface PermissionModule {
    key: string
    label: string
    children: PermissionModel[]
}

export type MetaPermissions = PermissionModule[]
