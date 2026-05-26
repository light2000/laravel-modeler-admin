<template>
    <div v-if="schema!.length" class="card table-search">
        <el-form ref="formRef" :model="formQuery" :inline="true" class="search-form">
            <template v-for="col in schema" :key="col.prop">
                <el-form-item :label="col.label" :prop="col.prop" class="search-item">
                    <!-- text -->
                    <el-input v-if="col.type === 'text'" v-model="formQuery[col.prop]" clearable placeholder="请输入" />

                    <!-- number -->
                    <el-input-number
                        v-else-if="col.type === 'number'"
                        v-model="formQuery[col.prop]"
                        controls-position="right"
                    />

                    <!-- numberrange -->
                    <el-space v-else-if="col.type === 'numberrange'" :size="8">
                        <el-input-number
                            :model-value="getNumberRangeValue(col.prop, 0)"
                            controls-position="right"
                            @update:model-value="v => setNumberRangeValue(col.prop, 0, v)"
                        />
                        <span>至</span>
                        <el-input-number
                            :model-value="getNumberRangeValue(col.prop, 1)"
                            controls-position="right"
                            @update:model-value="v => setNumberRangeValue(col.prop, 1, v)"
                        />
                    </el-space>

                    <!-- enum -->
                    <el-select
                        v-else-if="col.type === 'enum'"
                        :model-value="getEnumModelValue(col)"
                        clearable
                        placeholder="请选择"
                        @update:model-value="v => setEnumModelValue(col, v)"
                    >
                        <el-option
                            v-for="opt in getEnumOptions(col)"
                            :key="opt.value"
                            :label="opt.label"
                            :value="String(opt.value)"
                        />
                    </el-select>

                    <!-- date -->
                    <el-date-picker
                        v-else-if="col.type === 'date'"
                        v-model="formQuery[col.prop]"
                        type="date"
                        value-format="YYYY-MM-DD"
                    />

                    <!-- daterange -->
                    <el-date-picker
                        v-else-if="col.type === 'daterange'"
                        v-model="formQuery[col.prop]"
                        type="daterange"
                        :range-separator="'至'"
                        start-placeholder="开始日期"
                        end-placeholder="结束日期"
                        value-format="YYYY-MM-DD"
                        format="YYYY-MM-DD"
                    />

                    <!-- yearrange -->
                    <el-date-picker
                        v-else-if="col.type === 'yearrange'"
                        v-model="formQuery[col.prop]"
                        type="yearrange"
                        :range-separator="'至'"
                        start-placeholder="开始年份"
                        end-placeholder="结束年份"
                        value-format="YYYY"
                        format="YYYY"
                    />

                    <!-- fk -->
                    <RelationSelect
                        v-else-if="col.type === 'fk'"
                        :model-value="(formQuery as any)[col.prop]"
                        :field="`${col.model}.${col.prop}`"
                        :relation-module="col.relationModule"
                        :relation-model="col.relationModel"
                        clearable
                        placeholder="请选择"
                        @update:model-value="v => setFormValue(col.prop, v as any)"
                    />
                    <!-- boolean -->
                    <el-select
                        v-else-if="col.type === 'boolean'"
                        :model-value="(formQuery as any)[col.prop] || undefined"
                        clearable
                        placeholder="请选择"
                        @update:model-value="v => setFormValue(col.prop, v as any as any)"
                    >
                        <el-option
                            v-for="opt in [
                                { value: 1, label: '是' },
                                { value: 0, label: '否' }
                            ]"
                            :key="opt.value"
                            :label="opt.label"
                            :value="String(opt.value)"
                        />
                    </el-select>
                </el-form-item>
            </template>

            <!-- actions -->
            <el-form-item label-width="0" class="search-actions">
                <el-space>
                    <el-button :icon="Search" type="primary" @click="onSearch"> 查询 </el-button>
                    <el-button :icon="Refresh" @click="resetQuery"> 重置 </el-button>
                </el-space>
            </el-form-item>
        </el-form>
    </div>
</template>

<script setup lang="ts" generic="Query extends Record<string, any> & BaseQuery">
/* eslint-disable @typescript-eslint/no-explicit-any */
import { reactive, ref, watch } from 'vue'
import type { FormInstance } from 'element-plus'
import { Search, Refresh } from '@element-plus/icons-vue'
import type { SearchColumn } from '@/components/SearchForm/types'
import type { BaseQuery } from '@/composables/crud/types'
import { getOptions } from '@/meta/enums.utils'
import type { Option } from '@/meta/types'
import RelationSelect from '@/components/RelationSelect/index.vue'

defineOptions({
    name: 'ScaffSearchForm'
})

const props = defineProps<{
    schema: SearchColumn<Query>[]
    reload: () => void
}>()

const query = defineModel<Query>('query', { required: true })

const formQuery = reactive<Query>({} as Query)
const formRef = ref<FormInstance>()

watch(
    () => [props.schema, props.reload],
    () => resetForm(),
    { immediate: true }
)

function resetForm() {
    Object.keys(formQuery).forEach(k => delete formQuery[k])
    /* 初始化默认值 */
    props.schema.forEach(col => {
        if (col.defaultValue !== undefined) {
            setFormValue(col.prop, col.defaultValue as any)
            return
        }

        if (col.type === 'daterange' || col.type === 'yearrange' || col.type === 'numberrange') {
            if (col.defaultValue !== undefined) {
                formQuery[col.map.from] = col.defaultValue[0] ?? undefined
                formQuery[col.map.to] = col.defaultValue[1] ?? undefined
                return
            }
            return
        }
    })
    formRef.value?.clearValidate()
}

function getEnumOptions(col: SearchColumn<Query>): Option[] {
    if ('options' in col) return col.options ?? []
    if ('enumKey' in col) return getOptions(col.enumKey)
    return []
}

function getEnumModelValue(col: SearchColumn<Query>): string | undefined {
    const value = formQuery[col.prop]
    if (value === undefined || value === null || value === '') return undefined
    return String(value)
}

function setEnumModelValue(col: SearchColumn<Query>, value: string | undefined) {
    if (value === undefined || value === '') {
        delete formQuery[col.prop]
        return
    }
    const options = getEnumOptions(col)
    const matched = options.find(o => String(o.value) === value)
    formQuery[col.prop] = (matched ? matched.value : value) as any
}

function ensureNumberRange(prop: keyof Query & string): [number | undefined, number | undefined] {
    const value = formQuery[prop]
    if (!Array.isArray(value) || value.length !== 2) {
        formQuery[prop] = [undefined, undefined] as any
    }
    return formQuery[prop] as any
}

function getNumberRangeValue(prop: keyof Query & string, index: 0 | 1): number | undefined {
    return ensureNumberRange(prop)[index]
}

function setNumberRangeValue(prop: keyof Query & string, index: 0 | 1, value: number | undefined) {
    const range = ensureNumberRange(prop)
    range[index] = value
}

function setFormValue(prop: keyof Query & string, value: Query[keyof Query & string]) {
    formQuery[prop] = value
}

function hasMeaningfulValue(value: unknown): boolean {
    if (value === undefined || value === null || value === '') return false
    if (Array.isArray(value)) {
        return value.some(v => v !== undefined && v !== null && v !== '')
    }
    return true
}

function onSearch() {
    query.value.page = 1
    props.schema.forEach(col => {
        if (col.type === 'daterange' || col.type === 'numberrange' || col.type === 'yearrange') {
            const value = formQuery[col.prop]
            if (hasMeaningfulValue(value)) {
                query.value[col.map.from] = value[0] ?? undefined
                query.value[col.map.to] = value[1] ?? undefined
            } else {
                delete query.value[col.map.from]
                delete query.value[col.map.to]
            }
        } else {
            const value = formQuery[col.prop]
            if (hasMeaningfulValue(value)) {
                query.value[col.prop] = value as any
            } else {
                delete query.value[col.prop]
            }
        }
    })
}

function resetQuery() {
    resetForm()
    onSearch()
}
</script>

<style scoped>
:deep(.search-form.el-form--inline .search-item .el-form-item__content) {
    min-width: 140px;
}

:deep(.search-form.el-form--inline .search-item .el-select) {
    width: 100%;
}
</style>
