<template>
    <component :is="container" v-bind="mergedContainerProps" @close="onClose">
        <el-form ref="formRef" :model="model" :rules="formRules" :label-width="labelWidth ? labelWidth : '120px'">
            <template v-for="item in visibleSchema" :key="item.prop">
                <FormItem :item="item" :model="model as T" :mode="props.mode">
                    <template v-for="(_, name) in $slots" #[name]="slotData">
                        <slot :name="name" v-bind="slotData" />
                    </template>
                </FormItem>
            </template>
        </el-form>

        <template #footer>
            <el-space>
                <el-button @click="onClose">取消</el-button>
                <el-button type="primary" @click="onSubmit"> 确定 </el-button>
            </el-space>
        </template>
    </component>
</template>

<script setup lang="ts" generic="T extends Record<string, any>, R extends Record<string, any>">
/* eslint-disable @typescript-eslint/no-explicit-any */
import { computed, ref, reactive, watch, toRaw } from 'vue'
import type { FormSchemaItem } from './types'
import type { FormMode } from '@/composables/crud/types'
import type { FormInstance, FormRules, FormItemRule } from 'element-plus'
import FormItem from '@/components/FormItem/index.vue'

defineOptions({
    name: 'ScaffPopupForm'
})

const props = defineProps<{
    type?: 'dialog' | 'drawer'
    title?: string
    schema: FormSchemaItem<T>[]
    mode: FormMode
    record?: R
    labelWidth?: string
    containerProps?: Record<string, unknown>
    errors?: Record<string, string[]>
}>()
const visible = defineModel<boolean>('visible')

const onClose = () => {
    visible.value = false
}
const formRef = ref<FormInstance>()
// FormC 约定：model 为松散写
const model = reactive<T>({} as T)
const emit = defineEmits<{
    (e: 'submit', data: { values: T; mode?: FormMode }): void
}>()

const container = computed(() => (props.type === 'drawer' ? 'el-drawer' : 'el-dialog'))

const mergedContainerProps = computed(() => ({
    modelValue: visible.value,
    title: props.title,
    destroyOnClose: true,
    ...(props.containerProps ?? {})
}))

function resetForm() {
    Object.keys(model).forEach(k => delete model[k])
    props.schema.forEach(item => {
        // upload 的 fileList 由 SchemaFormItem 根据 model[prop] 同步，此处只写 model 即可
        // 处理 morph_select：需要同时初始化 {morph}_id 和 {morph}_type
        if (item.component === 'morph_select') {
            const morphIdProp = getMorphIdProp(item)
            const morphTypeProp = getMorphTypeProp(item)

            if (props.record?.[morphIdProp] !== undefined) {
                ;(model as any)[morphIdProp] = props.record[morphIdProp]
            } else if (item.default !== undefined) {
                ;(model as any)[morphIdProp] = item.default
            }

            if (props.record?.[morphTypeProp] !== undefined) {
                ;(model as any)[morphTypeProp] = props.record[morphTypeProp]
            }
        } else {
            // 其他组件类型
            if (props.record?.[item.prop] !== undefined) {
                model[item.prop] = props.record[item.prop]
            } else if (item.default !== undefined) {
                model[item.prop] = item.default
            }
        }
    })
    formRef.value?.clearValidate()
}

watch(
    () => [props.mode, props.record],
    () => resetForm(),
    { immediate: true }
)
watch(
    () => props.errors,
    errors => {
        if (errors && Object.keys(errors).length > 0) {
            const fields = Object.keys(errors)
            if (formRef.value) {
                fields.forEach(field => {
                    const fieldRef = formRef.value?.getField(field)
                    if (fieldRef) {
                        fieldRef.validateMessage = errors[field].join('\n')
                        fieldRef.validateState = 'error'
                    }
                })
            }
        }
    }
)
const visibleSchema = computed(() =>
    props.schema.filter(item => {
        if (typeof item.hidden === 'function') {
            return !item.hidden(props.mode)
        }
        return !item.hidden
    })
)

function getMorphIdProp(item: FormSchemaItem<T>): string {
    return `${item.prop}_id`
}

function getMorphTypeProp(item: FormSchemaItem<T>): string {
    return `${item.prop}_type`
}

const formRules = computed<FormRules>(() => {
    const rules: FormRules = {}

    props.schema.forEach(item => {
        const r: FormItemRule[] = []

        const required = typeof item.required === 'function' ? item.required(props.mode) : item.required

        if (required) {
            r.push({
                required: true,
                message: `请输入${item.label}`,
                trigger: 'blur'
            })
        }

        if (item.rules) {
            item.rules.forEach(rule => {
                if (typeof rule === 'function') {
                    r.push(rule({ model, mode: props.mode }))
                } else {
                    r.push(rule)
                }
            })
        }

        // 处理 morph_select：需要为 {prop}_id 和 {prop}_type 两个字段创建验证规则
        if (item.component === 'morph_select') {
            const morphIdProp = getMorphIdProp(item)
            const morphTypeProp = getMorphTypeProp(item)

            // 为 morph_id 字段创建验证规则
            const morphIdRules: FormItemRule[] = []

            if (required) {
                // 添加必填验证，同时检查 morphTypeProp 是否也有值
                // 使用 required: true 来显示红色"*"，使用 validator 来检查两个字段
                morphIdRules.push({
                    required: true,
                    message: `请选择${item.label}`,
                    trigger: 'blur',
                    validator: (rule, value, callback) => {
                        if (!value) {
                            callback(new Error(`请选择${item.label}`))
                            return
                        }
                        // 同时检查 morphTypeProp 是否有值
                        const morphTypeValue = (model as any)[morphTypeProp]
                        if (!morphTypeValue) {
                            callback(new Error(`请选择${item.label}类型`))
                            return
                        }
                        callback()
                    }
                })
            }

            // 添加自定义规则
            if (item.rules) {
                item.rules.forEach(rule => {
                    if (typeof rule === 'function') {
                        morphIdRules.push(rule({ model, mode: props.mode }))
                    } else {
                        morphIdRules.push(rule)
                    }
                })
            }

            if (morphIdRules.length) {
                rules[morphIdProp] = morphIdRules
            }

            // 为 morph_type 字段创建验证规则（如果 id 是必填的，type 也应该是必填的）
            if (required) {
                rules[morphTypeProp] = [
                    {
                        required: true,
                        message: `请选择${item.label}类型`,
                        trigger: 'blur'
                    }
                ]
            }

            // 如果 item.rules 存在，也为 type 字段添加相同的自定义规则
            if (item.rules) {
                const typeRules: FormItemRule[] = []
                item.rules.forEach(rule => {
                    if (typeof rule === 'function') {
                        typeRules.push(rule({ model, mode: props.mode }))
                    } else {
                        typeRules.push(rule)
                    }
                })
                if (typeRules.length) {
                    const existingRules = rules[morphTypeProp]
                    if (existingRules) {
                        // 确保 existingRules 是数组
                        const existingArray = Array.isArray(existingRules) ? existingRules : [existingRules]
                        rules[morphTypeProp] = [...existingArray, ...typeRules]
                    } else {
                        rules[morphTypeProp] = typeRules
                    }
                }
            }
        } else {
            // 其他组件类型，使用原来的逻辑
            if (r.length) {
                rules[item.prop] = r
            }
        }
    })

    return rules
})

const onSubmit = async () => {
    formRef.value?.validate(valid => {
        if (!valid) return
        const values = toRaw(model)

        const submitValues: Record<string, unknown> = {}

        props.schema.forEach(item => {
            // 不提交虚拟字段
            if (!item.virtual) {
                // 处理 morph_select：需要同时提交 {morph}_id 和 {morph}_type
                if (item.component === 'morph_select') {
                    const morphIdProp = getMorphIdProp(item)
                    const morphTypeProp = getMorphTypeProp(item)

                    if (item.normalize) {
                        submitValues[morphIdProp] = item.normalize(values[morphIdProp])
                        submitValues[morphTypeProp] = item.normalize(values[morphTypeProp])
                    } else {
                        submitValues[morphIdProp] = values[morphIdProp]
                        submitValues[morphTypeProp] = values[morphTypeProp]
                    }
                } else {
                    // 其他组件类型
                    if (item.normalize) {
                        submitValues[item.prop] = item.normalize(values[item.prop])
                    } else {
                        submitValues[item.prop] = values[item.prop]
                    }
                }
            }
        })

        emit('submit', { values: submitValues as T, mode: props.mode })
    })
}
</script>
