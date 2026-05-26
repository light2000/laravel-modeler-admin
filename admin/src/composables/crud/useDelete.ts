import { ElMessage, ElMessageBox } from 'element-plus'
import { getModelLabel } from '@/meta/permission.utils'

export function useDelete(request: (id: string) => Promise<void>, onSuccess?: () => void, modelKey: string = '') {
    const itemLabel = getModelLabel(modelKey, '数据')

    function execute(id: string) {
        ElMessageBox.confirm(`确定删除该${itemLabel}吗？`, '提示', {
            confirmButtonText: '确定',
            cancelButtonText: '取消',
            type: 'warning'
        }).then(() => {
            request(id)
                .then(() => {
                    ElMessage.success({ message: '删除成功' })
                    onSuccess?.()
                })
                .catch(error => {
                    ElMessage.error((error as Error).message)
                })
        })
    }

    return { execute }
}
