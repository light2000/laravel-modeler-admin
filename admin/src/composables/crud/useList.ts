import { computed, ref, watch } from 'vue'
import type { BaseQuery } from './types'
import { getActionTitle } from '@/meta/permission.utils'

export function useList<Query extends BaseQuery, Row>(
    request: (params: Query) => Promise<{ rows: Row[]; total: number }>,
    action: string = ''
) {
    const loading = ref(false)
    const rows = ref<Row[]>([])
    const total = ref(0)

    const query = ref<Query>({ page: 1, page_size: '10', sort: '' } as Query)
    const title = computed(() => {
        return getActionTitle(action, '数据列表')
    })
    async function reload() {
        loading.value = true
        try {
            const res = await request(query.value)
            rows.value = res.rows
            total.value = res.total
        } finally {
            loading.value = false
        }
    }

    // Watch nested changes on the query object (page, filters, etc.)
    watch(
        query,
        () => {
            //console.log('query changed', query.value)
            reload()
        },
        { deep: true }
    )

    reload()

    return {
        title,
        loading,
        rows,
        total,
        query,
        reload
    }
}
