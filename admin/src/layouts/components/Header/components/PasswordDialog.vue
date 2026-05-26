<template>
    <PopupForm
        v-model:visible="visible"
        title="修改密码"
        mode="update"
        :schema="schema"
        :loading="loading"
        :container-props="{ width: '500px', draggable: true, appendToBody: true }"
        @submit="submit"
    />
</template>

<script setup lang="ts">
import PopupForm from '@/components/PopupForm/index.vue'
import { meApi } from '@/api/modules/user/administrator.api'
import type { FormSchemaItem } from '@/components/PopupForm/types'
import type { ChangePasswordBody } from '@/api/modules/user/administrator.api'
import type { ChangePasswordRes } from '@/api/modules/user/administrator.api'
import { useActionForm } from '@/composables/crud/useActionForm'

defineOptions({
    name: 'ScaffPasswordDialog'
})

const { loading, open, visible, submit } = useActionForm<ChangePasswordBody, ChangePasswordRes>({
    submit: meApi.changePassword
})

const schema: FormSchemaItem<ChangePasswordBody>[] = [
    {
        prop: 'old_password',
        label: '原密码',
        component: 'input',
        required: true,
        componentProps: {
            type: 'password',
            showPassword: true,
            autocomplete: 'current-password'
        }
    },
    {
        prop: 'new_password',
        label: '新密码',
        component: 'input',
        required: true,
        rules: [
            ({ model }) => ({
                validator: (_, value, callback) => {
                    if (value === model.old_password) {
                        callback(new Error('旧密码和新密码不能相同'))
                    } else {
                        callback()
                    }
                },
                trigger: 'blur'
            })
        ],
        componentProps: {
            type: 'password',
            showPassword: true,
            autocomplete: 'new-password'
        }
    },
    {
        prop: 'new_password_confirm',
        label: '确认新密码',
        component: 'input',
        required: true,
        rules: [
            ({ model }) => ({
                validator: (_, value, callback) => {
                    if (value !== model.new_password) {
                        callback(new Error('新密码和确认密码不一致'))
                    } else {
                        callback()
                    }
                },
                trigger: 'blur'
            })
        ],
        virtual: true,
        componentProps: {
            type: 'password',
            showPassword: true,
            autocomplete: 'new-password'
        }
    }
]

defineExpose({ openDialog: open })
</script>
