/**
 * v-can
 * 按钮权限指令
 *
 *  v-can="user.role.store" 具有指定字符串'sys.menu.create_btn'内的权限
 *
 */
import { usePermissionStore } from '@/store/modules/permission'
import type { Directive, DirectiveBinding } from 'vue'

const can: Directive = {
    mounted(el: HTMLElement, binding: DirectiveBinding) {
        const { value } = binding
        const permissionStore = usePermissionStore()
        const permissions = permissionStore.permissions ?? []

        if (!permissions.includes(value)) {
            el.remove()
        }
    }
}

export default can
