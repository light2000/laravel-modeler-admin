import { ref, computed } from 'vue'
import { ElMessage } from 'element-plus'
import type { FormMode } from '@/composables/crud/types'
import { getActionTitle } from '@/meta/permission.utils'
import { ValidationError } from '@/api/core/client'
export function useForm<CreateForm, UpdateForm, FormRow>(options: {
    create?: (data: CreateForm) => Promise<FormRow>
    update?: (id: string, data: UpdateForm) => Promise<FormRow>
    edit?: (id: string) => Promise<FormRow>
    onSuccess?: () => void
    actions?: {
        create?: string
        update?: string
    }
}) {
    const visible = ref(false)
    const mode = ref<FormMode>('create')
    const currentId = ref<string | null>(null)
    const record = ref<FormRow>({} as FormRow)
    const loading = ref(false)
    const errors = ref<Record<string, string[]>>({})
    const title = computed(() => {
        if (mode.value === 'create') {
            return getActionTitle(options.actions?.create ?? '', '创建')
        }
        if (mode.value === 'update') {
            return getActionTitle(options.actions?.update ?? '', '修改')
        }
        return ''
    })

    function openCreate() {
        mode.value = 'create'
        currentId.value = null
        record.value = {}
        visible.value = true
    }

    async function openUpdate(id: string) {
        mode.value = 'update'
        currentId.value = id

        //没有回填数据功能，直接打开弹窗
        if (!options.edit) {
            visible.value = true
            return
        }

        loading.value = true
        try {
            record.value = await options.edit(id)
            visible.value = true
        } finally {
            loading.value = false
        }
    }

    async function submit({ values, mode }: { values: CreateForm | UpdateForm; mode?: FormMode }) {
        loading.value = true
        try {
            if (mode === 'create' && options.create) {
                await options.create(values as CreateForm)
            }
            if (mode === 'update' && options.update) {
                await options.update(currentId.value!, values as UpdateForm)
            }
            visible.value = false
            ElMessage.success({ message: '操作成功' })
            options.onSuccess?.()
        } catch (error) {
            if (error instanceof ValidationError) {
                //console.log(error.body)
                errors.value = error.body
            } else {
                ElMessage.error((error as Error).message)
            }
        } finally {
            loading.value = false
        }
    }

    return {
        visible,
        mode,
        record,
        loading,
        title,
        openCreate,
        openUpdate,
        submit,
        errors
    }
}
