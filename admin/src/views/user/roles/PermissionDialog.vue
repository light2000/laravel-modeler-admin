<template>
    <el-dialog
        :model-value="visible"
        title="设置权限"
        :destroy-on-close="true"
        :width="dialogWidth"
        draggable
        append-to-body
        class="role-permission-dialog"
        @close="close"
    >
        <div class="permission-content-area">
            <div class="menu-sidebar">
                <div class="sidebar-header">
                    <span class="sidebar-title">菜单分组</span>
                </div>
                <el-tree
                    ref="menuTreeRef"
                    class="menu-tree"
                    :data="metaPermissions"
                    node-key="key"
                    :default-expand-all="true"
                    :highlight-current="true"
                    :expand-on-click-node="false"
                    :props="treeProps"
                    :current-node-key="selectedNodeId"
                    @node-click="handleNodeClick"
                >
                    <template #default="{ data }">
                        <div
                            :class="[
                                'tree-node',
                                {
                                    selectable: isMenu(data),
                                    selected: selectedNodeId === data.key && isMenu(data)
                                }
                            ]"
                        >
                            <el-icon
                                v-if="isMenu(data)"
                                :style="{
                                    color: selectedNodeId === data.key ? '#67c23a' : '#bfbfbf',
                                    marginRight: '4px'
                                }"
                            >
                                <Menu />
                            </el-icon>
                            <el-icon v-else-if="isDirectory(data)" style="margin-right: 4px">
                                <Folder />
                            </el-icon>
                            <span>{{ data.label }}</span>
                        </div>
                    </template>
                </el-tree>
            </div>
            <div class="menu-permission-card">
                <div v-if="selectedNode">
                    <div class="menu-title-row">菜单：{{ selectedNode.label }}</div>
                    <!-- 否则显示功能权限等区块 -->
                    <div>
                        <div class="menu-buttons-row">
                            <div class="label-row">
                                功能权限：
                                <el-checkbox v-model="allChecked" class="checkbox-primary-style"> 全选 </el-checkbox>
                                <el-checkbox v-model="showPermissionsTag" class="checkbox-primary-style">
                                    标识
                                </el-checkbox>
                            </div>
                            <div class="divider-line"></div>
                            <el-checkbox-group v-model="selectedActionIds" @change="saveCurrentPermission">
                                <div
                                    v-for="btn in selectedNode.actions"
                                    :key="btn.key"
                                    class="permission-checkbox-item"
                                >
                                    <el-checkbox :value="btn.key">
                                        {{ btn.label }}
                                    </el-checkbox>
                                    <template v-if="showPermissionsTag">
                                        <el-tag size="small" effect="dark" type="info" class="permission-tag">
                                            {{ btn.key }}
                                        </el-tag>
                                        <el-button
                                            text
                                            size="small"
                                            style="vertical-align: middle; margin-left: 2px"
                                            title="复制标识"
                                            @click.stop="copyPermission(btn.key)"
                                        >
                                            <el-icon :size="18">
                                                <CopyDocument />
                                            </el-icon>
                                        </el-button>
                                    </template>
                                </div>
                            </el-checkbox-group>
                        </div>
                    </div>
                </div>
                <div v-else style="color: #bbb; text-align: center; margin-top: 100px">请选择菜单进行权限配置</div>
            </div>
        </div>
        <template #footer>
            <el-button @click="close">取消</el-button>
            <el-button type="primary" :loading="loading" @click="handleSubmit">确定</el-button>
        </template>
    </el-dialog>
</template>

<script setup lang="ts">
import { ref, computed, nextTick, watch } from 'vue'
import { ElMessage } from 'element-plus'
import { Folder, Menu, CopyDocument } from '@element-plus/icons-vue'
import type { RolePermissionsEdit } from '@/api/modules/user/role.api'
import type { PermissionModule, PermissionModel } from '@/meta/types'
import { metaPermissions } from '@/meta/permissions'

const props = defineProps<{
    role?: RolePermissionsEdit
    loading: boolean
}>()

const visible = defineModel<boolean>('visible')

const close = () => {
    selectedNode.value = null
    selectedNodeId.value = ''
    selectedActionIds.value = []
    visible.value = false
}

const emit = defineEmits<{
    (e: 'submit', data: { values: RolePermissionsEdit; mode: 'update' }): void
}>()

const treeProps = {
    children: 'children',
    label: 'title',
    value: 'key'
}
const dialogWidth = computed(() => {
    const w = Math.max(900, Math.min(window.innerWidth * 0.85, 1200))
    return `${w}px`
})

const isDirectory = (node: PermissionModule | PermissionModel) => !isMenu(node)
const isMenu = (node: PermissionModule | PermissionModel): node is PermissionModel =>
    Array.isArray((node as PermissionModel)?.actions)
const selectedNodeId = ref<string>('')
const selectedNode = ref<PermissionModel | null>(null)
const selectedActionIds = ref<string[]>([])

const currentPermissions = ref<Set<string>>(new Set())
// 使用 el-tree 的 node-click 事件
const handleNodeClick = (permissionModel: PermissionModel) => {
    selectedNode.value = permissionModel
    selectedNodeId.value = permissionModel.key
    // 🔥 核心：根据当前角色权限，计算该菜单下已选权限
    const actionKeys = permissionModel.actions?.map(a => a.key) || []

    selectedActionIds.value = Array.from(currentPermissions.value).filter(p => actionKeys.includes(p))
}

const copyPermission = (perm: string) => {
    navigator.clipboard
        .writeText(perm)
        .then(() => ElMessage.success('标识已复制'))
        .catch(() => ElMessage.error('复制失败，请手动复制'))
}

const showPermissionsTag = ref(false)

const allChecked = computed({
    get: () =>
        selectedNode.value?.actions?.length && selectedActionIds.value.length === selectedNode.value.actions.length,
    set: (val: boolean) => {
        if (val && selectedNode.value?.actions) {
            selectedActionIds.value = selectedNode.value.actions.map(btn => btn.key)
        } else {
            selectedActionIds.value = []
        }
    }
})

const saveCurrentPermission = () => {
    if (!selectedNode.value?.actions) return

    const actionKeys = selectedNode.value.actions.map(a => a.key)
    // ① 先删除当前菜单下所有 action
    for (const key of actionKeys) {
        currentPermissions.value.delete(key)
    }
    // ② 再加入当前勾选的 action
    for (const key of selectedActionIds.value) {
        currentPermissions.value.add(key)
    }
}

const handleSubmit = () => {
    emit('submit', { values: { permissions: Array.from(currentPermissions.value) }, mode: 'update' })
}

watch(visible, val => {
    if (val) {
        // 每次打开 dialog，都重新拷贝一份
        currentPermissions.value = new Set(props.role?.permissions || [])
        if (metaPermissions.length) {
            nextTick().then(() => {
                const firstMenu = findFirstMenu(metaPermissions)
                if (firstMenu) handleNodeClick(firstMenu)
            })
        }
    }
})

const findFirstMenu = (permissionModules: PermissionModule[]): PermissionModel | null => {
    for (const node of permissionModules) {
        if (node.children?.length) {
            const found = node.children[0]
            if (found) return found
        }
    }
    return null
}
</script>

<style scoped lang="scss">
.role-permission-dialog {
    .el-dialog__body {
        display: flex;
        flex-direction: column;
        height: 80vh;
        min-height: 600px;
        padding: 32px 32px 0 32px;
        background: var(--el-bg-color, #fafbfc);
        /* 亮暗模式自适应 */
        transition: background 0.2s;

        // dialog边框色
        border-radius: 12px;
        border: 1px solid var(--el-border-color, #f0f0f0);
        box-shadow: 0 8px 40px 0 var(--el-box-shadow-color, rgba(0, 0, 0, 0.17));
    }

    .role-base-form {
        flex-shrink: 0;
        margin-bottom: 18px;
        background: transparent;

        .el-form-item__label {
            color: var(--el-text-color-primary, #222);
        }

        .el-input__inner {
            background: var(--el-fill-color-blank, #fff);
            color: var(--el-text-color-regular, #222);
            border-color: var(--el-border-color, #e4e7ed);
        }
    }

    .permission-content-area {
        flex: 1 1 0;
        display: flex;
        min-height: 0;
        overflow: hidden;

        .menu-sidebar {
            width: 260px;
            min-width: 180px;
            background: var(--el-bg-color-overlay, #fff);
            border-radius: 8px;
            margin-right: 32px;
            padding: 12px 0;
            border: 1px solid var(--el-border-color, #f0f0f0);
            box-shadow: 1px 0 8px 0 var(--el-box-shadow-light, rgba(64, 158, 255, 0.04));
            display: flex;
            flex-direction: column;
            overflow: auto;
            max-height: 100%;
            min-height: 0;

            /* ------ 修改开始 ------ */
            .sidebar-header {
                display: flex;
                flex-wrap: wrap; // 允许内容自动换行
                align-items: center;
                justify-content: flex-start;
                padding: 0 16px 10px 16px; // 左右都留空，原来是18px，略微收窄也可
                border-bottom: 1px solid #f4f4f4;
                margin-bottom: 10px;

                .sidebar-title {
                    font-weight: bold;
                    color: #222;
                    margin-right: 16px; // 标题与后方内容分隔
                    flex-shrink: 0; // 标题不压缩
                }

                .sidebar-actions {
                    display: flex;
                    flex-wrap: wrap; // 多内容自动换行
                    align-items: center;
                    gap: 8px;
                    min-width: 0; // 允许内容收缩

                    .el-link {
                        margin-left: 0; // 去掉左间距
                        color: var(--el-color-primary);
                    }
                }

                .el-input {
                    margin-left: 12px;
                }
            }

            /* ------ 修改结束 ------ */

            .menu-tree {
                .el-tree-node__content {
                    padding: 3px 0;
                    color: var(--el-text-color-regular, #444);
                }

                .tree-node {
                    display: flex;
                    align-items: center;
                    cursor: pointer;
                    border-radius: 5px;
                    padding: 3px 8px;
                    margin-bottom: 2px;
                    color: var(--el-text-color-regular, #222);
                    background: transparent;
                    transition:
                        background 0.2s,
                        border 0.2s;

                    &.selectable:hover {
                        background: var(--el-fill-color-light, #25272b);
                    }

                    &.selected {
                        background: var(--el-color-primary-light-9, #e6f7ff);
                        border-left: 4px solid var(--el-color-primary, #409eff);
                        font-weight: 500;
                        color: var(--el-color-primary, #409eff);
                    }

                    .menu-config-dot {
                        width: 8px;
                        height: 8px;
                        border-radius: 50%;
                        background: var(--el-color-primary, #409eff);
                        margin-right: 6px;
                        vertical-align: middle;
                    }

                    .menu-tree-tag {
                        margin-left: 6px;
                        padding: 0 3px;
                        font-size: 10px;
                        height: 18px;
                        line-height: 18px;
                        vertical-align: middle;
                        border-radius: 8px;
                        background: var(--el-bg-color-page, #e6fffa);
                        color: var(--el-color-success, #67c23a);
                    }
                }
            }
        }

        .menu-permission-card {
            flex: 1 1 0;
            min-width: 400px;
            background: var(--el-bg-color-overlay, #fff);
            border-radius: 8px;
            border: 1px solid var(--el-border-color, #f0f0f0);
            padding: 24px 30px 10px 30px;
            box-shadow: 0 1px 8px 0 var(--el-box-shadow-color, rgba(0, 0, 0, 0.05));
            color: var(--el-text-color-primary, #333);

            .menu-title-row {
                font-size: 16px;
                font-weight: 600;
                margin-bottom: 18px;
            }

            .label-row {
                font-size: 14px;
                margin-bottom: 8px;
                display: flex;
                align-items: center;
            }

            .divider-line {
                border-top: 1px dashed var(--el-border-color-light, #3d4148);
                margin: 8px 0 10px 0;
            }

            .menu-buttons-row {
                margin-bottom: 18px;

                .el-checkbox-group {
                    display: flex;
                    flex-wrap: wrap;
                    gap: 18px 32px;

                    .el-checkbox {
                        --el-checkbox-checked-bg-color: var(--el-color-primary, #409eff);
                        --el-checkbox-checked-border-color: var(--el-color-primary, #409eff);
                        color: var(--el-color-primary, #409eff);
                    }
                }
            }

            .menu-status-row {
                margin-top: 18px;
            }

            .data-scope-tag {
                font-size: 12px;
                margin-left: 8px;
            }

            .disabled-card {
                opacity: 0.5;
                pointer-events: none;
            }

            .no-data-scope-tip {
                margin: 24px 0;
                color: var(--el-text-color-disabled, #bbb);
            }
        }
    }

    .el-dialog__footer {
        background: var(--el-bg-color, #fafbfc);
        border-top: 1px solid var(--el-border-color, #f0f0f0);
        padding: 18px 32px 24px 32px;

        .el-button + .el-button {
            margin-left: 10px;
        }
    }

    .permission-checkbox-group {
        display: flex;
        flex-wrap: wrap;
        gap: 18px 32px;
        margin-top: 8px;
    }

    .permission-checkbox-item {
        display: flex;
        align-items: center;
        margin-bottom: 6px;
        min-width: 220px;

        .el-checkbox__label {
            color: var(--el-text-color-regular, #222) !important;
        }
    }

    .permission-tag {
        margin-left: 6px;
        font-size: 13px;
        font-family: monospace;
        font-weight: bold;
        letter-spacing: 0.5px;
        padding: 0 5px;
        background: var(--el-bg-color-page, #e6f7ff);
        color: var(--el-color-primary, #409eff);
        border: 1px solid var(--el-color-primary-light-7, #91d5ff);
    }
}

// 覆盖 element-plus button: dark-模式主色等
:deep(.el-button--primary) {
    background: var(--el-color-primary, #409eff);
    border-color: var(--el-color-primary, #409eff);
}

:deep(.el-link) {
    color: var(--el-color-primary) !important;
}

:deep(.checkbox-primary-style) {
    --el-checkbox-checked-bg-color: var(--el-color-primary, #409eff);
    --el-checkbox-checked-border-color: var(--el-color-primary, #409eff);
    color: var(--el-color-primary, #409eff);
}

:deep(.checkbox-primary-style .el-checkbox__label),
:deep(.checkbox-primary-style.is-checked .el-checkbox__label) {
    color: var(--el-color-primary, #409eff) !important;
    transition:
        color 0.2s,
        text-decoration-color 0.2s;
}

:deep(.checkbox-primary-style .el-checkbox__label:hover) {
    color: var(--el-color-primary-dark-2, #1976d2) !important;
    text-decoration: underline;
    text-decoration-color: var(--el-color-primary-dark-2, #1976d2);
}
</style>
