import { reactive } from 'vue'
import type { CrudApi, BaseQuery } from './types'
import { useList } from './useList'
import { useForm } from './useForm'
import { useDelete } from './useDelete'
import { useDetail } from './useDetail'

export function useCrud<Row, Detail, FormRow, Query extends BaseQuery, CreateForm, UpdateForm>(
    api: CrudApi<Row, Detail, FormRow, Query, CreateForm, UpdateForm>
) {
    const list = reactive(useList(api.list, `${api.meta.module}.${api.meta.model}.index`))

    const form = reactive(
        useForm<CreateForm, UpdateForm, FormRow>({
            create: api.create,
            update: api.update,
            edit: api.edit,
            onSuccess: () => {
                list.reload()
            },
            actions: {
                create: `${api.meta.module}.${api.meta.model}.store`,
                update: `${api.meta.module}.${api.meta.model}.update`
            }
        })
    )

    const detail = reactive(useDetail(api.detail, `${api.meta.module}.${api.meta.model}.show`))

    const del = reactive(useDelete(api.remove, list.reload, `${api.meta.module}.${api.meta.model}`))

    return {
        list,
        form,
        detail,
        del
    }
}
