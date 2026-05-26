<template>
    <PopupForm
        v-model:visible="visible"
        title="个人信息"
        mode="update"
        :schema="schema"
        :record="record"
        :loading="loading"
        :container-props="{ width: '500px', draggable: true, appendToBody: true }"
        @submit="submit"
    />
</template>

<script setup lang="ts">
import type { FormSchemaItem } from '@/components/PopupForm/types'
import type { UpdateProfileBody } from '@/api/modules/user/administrator.api'
import type { UpdateProfileRes } from '@/api/modules/user/administrator.api'
import { meApi } from '@/api/modules/user/administrator.api'
import PopupForm from '@/components/PopupForm/index.vue'
import { useActionForm } from '@/composables/crud/useActionForm'

defineOptions({
    name: 'ScaffInfoDialog'
})

const { loading, open, visible, record, submit } = useActionForm<UpdateProfileBody, UpdateProfileRes>({
    submit: meApi.updateProfile,
    load: meApi.profile
})

const schema: FormSchemaItem<UpdateProfileBody>[] = [
    {
        prop: 'nickname',
        label: '昵称',
        component: 'input',
        required: true
    }
]

defineExpose({ openDialog: open })
</script>
