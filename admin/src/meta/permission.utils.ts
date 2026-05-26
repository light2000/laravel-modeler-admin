import { metaPermissions } from './permissions'

export function getActionTitle(key: string, defaultTitle: string = ''): string {
    for (const module of metaPermissions) {
        for (const model of module.children) {
            for (const action of model.actions ?? []) {
                if (action.key === key) {
                    return action.label
                }
            }
        }
    }
    return defaultTitle
}

export function getModelLabel(key: string, defaultLabel: string = ''): string {
    for (const module of metaPermissions) {
        for (const model of module.children) {
            if (model.key === key) {
                return model.label
            }
        }
    }
    return defaultLabel
}
