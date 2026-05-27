<template>
    <div class="relation-select">
        <!-- 多态关系：先选择类型 -->
        <template v-if="polymorphic">
            <el-select
                v-model="morphTypeValue"
                :clearable="clearable"
                :placeholder="morphTypePlaceholder"
                :disabled="disabled"
                class="relation-select-type"
                @change="handleMorphTypeChange"
            >
                <el-option
                    v-for="option in morphTypeOptions"
                    :key="option.value"
                    :label="option.label"
                    :value="option.value"
                />
            </el-select>
            <el-select
                v-model="morphIdValue"
                :clearable="clearable"
                :placeholder="morphIdPlaceholder"
                :disabled="disabled || !morphTypeValue"
                :loading="loading"
                class="relation-select-id"
                filterable
                remote
                :remote-method="debouncedSearchMorphIdOptions"
            >
                <el-option
                    v-for="option in morphIdOptions"
                    :key="option.value"
                    :label="option.label"
                    :value="option.value"
                />
            </el-select>
        </template>

        <!-- 普通FK关系 -->
        <el-select
            v-else
            :model-value="modelValue"
            :clearable="clearable"
            :placeholder="placeholder"
            :disabled="disabled"
            :loading="loading"
            :multiple="multiple"
            filterable
            remote
            :remote-method="debouncedSearchOptions"
            @update:model-value="handleChange"
        >
            <el-option v-for="option in options" :key="option.value" :label="option.label" :value="option.value" />
        </el-select>
    </div>
</template>

<script setup lang="ts">
/* eslint-disable @typescript-eslint/no-explicit-any */
import { ref, computed, watch, onMounted } from 'vue'
import type { Option } from '@/meta/types'
import type { RelationSelectProps, PolymorphicTypes } from './types'
import http from '@/api/core/client'
import polymorphicTypesJson from '@/meta/polymorphic_types.json'

// 防抖函数
function debounce<T extends (...args: any[]) => any>(fn: T, delay: number): T {
    let timer: ReturnType<typeof setTimeout> | null = null
    return ((...args: any[]) => {
        if (timer) {
            clearTimeout(timer)
        }
        timer = setTimeout(() => {
            fn(...args)
        }, delay)
    }) as T
}

defineOptions({
    name: 'RelationSelect'
})

const props = withDefaults(defineProps<RelationSelectProps>(), {
    polymorphic: false,
    clearable: true,
    placeholder: '请选择',
    disabled: false,
    multiple: false
})

const emit = defineEmits<{
    'update:modelValue': [value: number | string | number[] | string[] | undefined]
    'update:morphType': [value: string | undefined]
    'update:morphId': [value: number | string | undefined]
}>()

const modelValue = defineModel<number | string | number[] | string[] | undefined>('modelValue')
const morphTypeModel = defineModel<string | undefined>('morphType')
const morphIdModel = defineModel<number | string | undefined>('morphId')

// 多态相关
const morphTypeValue = computed({
    get: () => morphTypeModel.value,
    set: val => {
        morphTypeModel.value = val
        emit('update:morphType', val)
    }
})

const morphIdValue = computed({
    get: () => morphIdModel.value,
    set: val => {
        morphIdModel.value = val
        emit('update:morphId', val)
    }
})

const polymorphicTypes = polymorphicTypesJson as PolymorphicTypes

// 多态类型选项
const morphTypeOptions = computed(() => {
    if (!props.field) return []
    return polymorphicTypes[`${props.field}_type`] || []
})

// 多态ID选项
const morphIdOptions = ref<Option[]>([])
const loading = ref(false)

// 普通FK选项
const options = ref<Option[]>([])

// 占位符
const morphTypePlaceholder = computed(() => {
    return props.placeholder || '请选择类型'
})

const morphIdPlaceholder = computed(() => {
    if (!morphTypeValue.value) {
        return '请先选择类型'
    }
    return props.placeholder || '请选择'
})

// 处理多态类型变化
function handleMorphTypeChange(value: string | undefined) {
    // 清空ID值
    morphIdValue.value = undefined
    morphIdOptions.value = []

    if (value) {
        // 加载对应的ID选项
        loadMorphIdOptions()
    }
}

// 搜索多态ID选项（支持 q 和 id 参数）
async function searchMorphIdOptions(query: string, id?: number | string) {
    if (!morphTypeValue.value || !props.field) {
        morphIdOptions.value = []
        return
    }

    // 从 polymorphic_types.json 获取配置
    // configKey 格式：product.supplier_type
    const configKey = `${props.field}_type`

    const typeOptions = polymorphicTypes[configKey] || []
    const selectedType = typeOptions.find(opt => opt.value === morphTypeValue.value)

    if (!selectedType) {
        morphIdOptions.value = []
        return
    }

    // 加上 _id
    const forParam = `${props.field}_id`

    loading.value = true
    try {
        const params: Record<string, string> = {
            type: String(selectedType.value),
            for: forParam
        }
        // 如果有搜索关键词，添加 q 参数
        if (query && query.trim()) {
            params.q = query.trim()
        }
        // 如果指定了 id，添加 id 参数
        if (id !== undefined && id !== null) {
            params.id = String(id)
        }

        const response = await http.get<{ rows: Option[]; total: number }>('/options/polymorphic', {
            params
        })
        morphIdOptions.value = (response as any).rows || []
    } catch (error) {
        console.error('Failed to load polymorphic options:', error)
        morphIdOptions.value = []
    } finally {
        loading.value = false
    }
}

// 加载多态ID选项（兼容默认值）
async function loadMorphIdOptions() {
    if (!morphTypeValue.value || !props.field) {
        morphIdOptions.value = []
        return
    }

    // 如果存在默认值，需要合并第一页和默认值的数据
    if (morphIdValue.value !== undefined && morphIdValue.value !== null) {
        try {
            // 先请求第一页数据
            await searchMorphIdOptions('')
            const firstPageOptions = [...morphIdOptions.value]

            // 再请求默认值对应的数据
            await searchMorphIdOptions('', morphIdValue.value)
            const defaultOption = morphIdOptions.value[0]

            // 合并并排重（按 value 去重）
            const mergedOptions = new Map<number | string, Option>()

            // 先添加默认值的数据（确保它在列表中）
            if (defaultOption) {
                mergedOptions.set(defaultOption.value, defaultOption)
            }

            // 再添加第一页的数据
            firstPageOptions.forEach(opt => {
                if (!mergedOptions.has(opt.value)) {
                    mergedOptions.set(opt.value, opt)
                }
            })

            morphIdOptions.value = Array.from(mergedOptions.values())
        } catch (error) {
            console.error('Failed to load morph id options with default value:', error)
            // 如果合并失败，至少尝试加载第一页
            await searchMorphIdOptions('')
        }
    } else {
        // 没有默认值，只加载第一页
        await searchMorphIdOptions('')
    }
}

function getSelectedIds(): Array<number | string> {
    const value = modelValue.value
    if (value === undefined || value === null) {
        return []
    }
    return Array.isArray(value) ? value : [value]
}

// 搜索普通FK选项（支持 q、id 和 ids 参数）
async function searchOptions(query: string, id?: number | string, ids?: string) {
    const module = props.relationModule
    const targetModel = props.relationModel

    if (!module || !targetModel || !props.field) {
        options.value = []
        return
    }

    loading.value = true
    try {
        const params: Record<string, string> = {
            for: props.field
        }
        // 如果有搜索关键词，添加 q 参数
        if (query && query.trim()) {
            params.q = query.trim()
        }
        // 如果指定了 id，添加 id 参数
        if (id !== undefined && id !== null) {
            params.id = String(id)
        }
        if (ids) {
            params.ids = ids
        }

        const response = await http.get<{ rows: Option[]; total: number }>(`/options/${module}/${targetModel}`, {
            params
        })
        options.value = (response as any).rows || []
    } catch (error) {
        console.error('Failed to load options:', error)
        options.value = []
    } finally {
        loading.value = false
    }
}

// 加载普通FK选项（兼容默认值）
async function loadOptions() {
    const module = props.relationModule
    const targetModel = props.relationModel

    if (!module || !targetModel || !props.field) {
        options.value = []
        return
    }

    const selectedIds = getSelectedIds()

    // 如果存在默认值，需要合并第一页和默认值的数据
    if (selectedIds.length > 0) {
        try {
            await searchOptions('')
            const firstPageOptions = [...options.value]

            if (props.multiple) {
                await searchOptions('', undefined, selectedIds.map(String).join(','))
            } else {
                await searchOptions('', selectedIds[0])
            }
            const selectedOptions = [...options.value]

            const mergedOptions = new Map<number | string, Option>()
            selectedOptions.forEach(opt => mergedOptions.set(opt.value, opt))
            firstPageOptions.forEach(opt => {
                if (!mergedOptions.has(opt.value)) {
                    mergedOptions.set(opt.value, opt)
                }
            })

            options.value = Array.from(mergedOptions.values())
        } catch (error) {
            console.error('Failed to load options with default value:', error)
            await searchOptions('')
        }
    } else {
        await searchOptions('')
    }
}

// 防抖版本的搜索函数
const debouncedSearchOptions = debounce(searchOptions, 300)
const debouncedSearchMorphIdOptions = debounce(searchMorphIdOptions, 300)

// 处理普通FK变化
function handleChange(value: number | string | number[] | string[] | undefined) {
    modelValue.value = value
    emit('update:modelValue', value)
}

// 监听多态类型字段变化，自动加载选项
watch(
    () => props.field,
    () => {
        if (props.polymorphic && props.field && morphTypeValue.value) {
            loadMorphIdOptions()
        }
    }
)

onMounted(() => {
    // 如果已有值，自动加载选项
    if (props.polymorphic && morphTypeValue.value) {
        loadMorphIdOptions()
    } else if (!props.polymorphic && getSelectedIds().length > 0) {
        const module = props.relationModule
        const targetModel = props.relationModel
        if (module && targetModel && props.field) {
            loadOptions()
        }
    }
})
</script>

<style scoped lang="scss">
.relation-select {
    display: flex;
    gap: 8px;
    width: 100%;

    .relation-select-type {
        flex: 0 0 150px;
    }

    .relation-select-id {
        flex: 1;
    }
}
</style>
