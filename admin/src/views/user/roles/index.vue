<template>
    <div class="table-box">
        <!-- Search -->
        <SearchForm v-model:query="list.query" :schema="roleSearchSchema" :reload="list.reload" />
        <!-- Table -->
        <ProTable
            v-model:query="list.query"
            :columns="roleTableSchema"
            selectable
            :loading="list.loading"
            :rows="list.rows"
            :total="list.total"
            :reload="list.reload"
        >
            <!-- toolbar -->
            <template #toolbar="scope">
                <el-button v-can="'user.role.store'" type="primary" :icon="CirclePlus" @click="form.openCreate()">
                    新增角色
                </el-button>
                <el-button
                    v-can="'user.role.destroy'"
                    type="danger"
                    :icon="Delete"
                    plain
                    :disabled="!scope.isSelected"
                    @click="del.execute(scope.selectedIds)"
                >
                    批量删除
                </el-button>
            </template>

            <!-- operation -->
            <template #operation="{ row }">
                <el-button
                    v-can="'user.role.assign_permissions'"
                    type="primary"
                    link
                    :icon="EditPen"
                    @click="permissionForm.openUpdate(row.id)"
                    >权限</el-button
                >
                <el-button
                    v-can="'user.role.update'"
                    type="primary"
                    link
                    :icon="EditPen"
                    @click="form.openUpdate(row.id)"
                    >编辑</el-button
                >
                <el-button v-can="'user.role.destroy'" link type="danger" :icon="Delete" @click="del.execute(row.id)"
                    >删除</el-button
                >
                <el-button v-can="'user.role.show'" link type="primary" :icon="View" @click="detail.open(row.id)"
                    >详情</el-button
                >
            </template>
        </ProTable>
        <!-- Dialog Form -->
        <PopupForm
            v-model:visible="form.visible"
            :mode="form.mode"
            :schema="roleFormSchema"
            :record="form.record"
            :title="form.title"
            :errors="form.errors"
            @submit="form.submit"
        />
        <PopupDetail
            v-model:visible="detail.visible"
            type="dialog"
            :title="detail.title"
            :schema="roleDetailSchema"
            :data="detail.record"
            :column="2"
        />
        <PermissionDialog
            v-model:visible="permissionForm.visible"
            :role="permissionForm.record"
            :loading="permissionForm.loading"
            @submit="permissionForm.submit"
        />
    </div>
</template>
<script setup lang="ts">
import { reactive } from 'vue'
import { CirclePlus, Delete, EditPen, View } from '@element-plus/icons-vue'
import SearchForm from '@/components/SearchForm/index.vue'
import ProTable from '@/components/ProTable/index.vue'
import PopupForm from '@/components/PopupForm/index.vue'
import PopupDetail from '@/components/PopupDetail/index.vue'
import {
    roleApi,
    RoleCreate,
    rolePermissionsAction,
    type RolePermissionsEdit,
    type RolePermissionsUpdate
} from '@/api/modules/user/role.api'
import { roleSearchSchema, roleTableSchema, roleFormSchema, roleDetailSchema } from './schemas'
import { useCrud } from '@/composables/crud/useCrud'
import PermissionDialog from './PermissionDialog.vue'
import { useForm } from '@/composables/crud/useForm'

defineOptions({
    name: 'RoleIndex'
})

const { list, form, del, detail } = useCrud(roleApi)
const permissionForm = reactive(
    useForm<RoleCreate, RolePermissionsUpdate, RolePermissionsEdit>({
        update: rolePermissionsAction.update,
        edit: rolePermissionsAction.edit,
        actions: {
            update: `${rolePermissionsAction.meta.module}.${rolePermissionsAction.meta.model}.permissions.update`
        }
    })
)
</script>

<style scoped></style>
