import { ref, computed } from 'vue'
import { getActionTitle } from '@/meta/permission.utils'

export function useActionForm<Form, Res>(options: {
    submit: (data: Form) => Promise<Res>
    load?: () => Promise<Partial<Form>> // 可选回填
    action?: string
}) {
    const visible = ref(false)
    const loading = ref(false)
    const record = ref<Partial<Form>>({})
    const title = computed(() => {
        return getActionTitle(options.action ?? '', '操作')
    })

    async function open() {
        if (options.load) {
            loading.value = true
            try {
                record.value = await options.load()
            } finally {
                loading.value = false
            }
        }
        visible.value = true
    }

    async function submit({ values }: { values: Form }) {
        loading.value = true
        try {
            await options.submit(values)
            visible.value = false
        } finally {
            loading.value = false
        }
    }

    return {
        visible,
        loading,
        record,
        title,
        open,
        submit
    }
}
