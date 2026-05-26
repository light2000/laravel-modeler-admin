<template>
    <component :is="container" v-bind="mergedContainerProps" @close="onClose">
        <el-card shadow="never">
            <el-descriptions :column="column" border size="default">
                <el-descriptions-item
                    v-for="item in schema"
                    :key="item.prop"
                    :label="item.label"
                    :span="item.span || 1"
                >
                    <FieldValue :field="item" :value="data[item.prop]" :row="data" />
                </el-descriptions-item>
            </el-descriptions>
        </el-card>
        <template #footer>
            <el-button @click="onClose">关闭</el-button>
        </template>
    </component>
</template>

<script setup lang="ts" generic="T">
import { computed } from 'vue'
import type { DetailSchemaItem } from './types'
import FieldValue from '@/components/FieldValue/index.vue'

defineOptions({
    name: 'ScaffPopupDetail'
})

const props = defineProps<{
    type?: 'dialog' | 'drawer'
    title: string
    schema: DetailSchemaItem<T>[]
    data: T
    column?: number
    containerProps?: Record<string, unknown>
}>()

const visible = defineModel<boolean>('visible')

const onClose = () => {
    visible.value = false
}

/**
 * 容器类型
 */
const container = computed(() => (props.type === 'drawer' ? 'el-drawer' : 'el-dialog'))

/**
 * 容器参数统一收敛
 */
const mergedContainerProps = computed(() => ({
    modelValue: visible.value,
    title: props.title,
    destroyOnClose: true,
    ...(props.type === 'drawer' ? { size: '50%' } : { width: '600px' }),
    ...(props.containerProps ?? {})
}))
</script>
