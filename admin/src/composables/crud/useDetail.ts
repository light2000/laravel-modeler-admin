import { computed, ref } from 'vue'
import { ElMessage } from 'element-plus'
import { getActionTitle } from '@/meta/permission.utils'

export function useDetail<Detail>(request: (id: string) => Promise<Detail>, action: string = '') {
    const visible = ref(false)
    const loading = ref(false)
    const record = ref<Detail>({} as Detail)
    const title = computed(() => {
        return getActionTitle(action, '详情')
    })
    async function open(id: string) {
        loading.value = true
        try {
            record.value = await request(id)
            visible.value = true
        } catch (error) {
            ElMessage.error((error as Error).message)
        } finally {
            loading.value = false
        }
    }

    return {
        visible,
        loading,
        record,
        title,
        open
    }
}
