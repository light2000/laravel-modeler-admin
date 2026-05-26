<template>
    <el-form-item :label="item.label" :prop="formItemProp">
        <!-- Input -->
        <el-input
            v-if="item.component === 'input'"
            v-model="model[item.prop]"
            v-bind="item.componentProps"
            :disabled="isDisabled()"
        />

        <el-input
            v-else-if="item.component === 'password'"
            v-model="model[item.prop]"
            type="password"
            v-bind="item.componentProps"
            :disabled="isDisabled()"
            show-password
        />
        <!-- Textarea -->
        <el-input
            v-else-if="item.component === 'textarea'"
            v-model="model[item.prop]"
            type="textarea"
            v-bind="item.componentProps"
            :disabled="isDisabled()"
        />

        <!-- Number -->
        <el-input-number
            v-else-if="item.component === 'number'"
            v-model="model[item.prop]"
            v-bind="item.componentProps"
            :disabled="isDisabled()"
        />

        <!-- Select -->
        <el-select
            v-else-if="item.component === 'select'"
            v-model="model[item.prop]"
            v-bind="item.componentProps"
            :disabled="isDisabled()"
        >
            <el-option v-for="opt in item.options || []" :key="opt.value" :label="opt.label" :value="opt.value" />
        </el-select>

        <!-- Switch -->
        <el-switch v-else-if="item.component === 'switch'" v-model="model[item.prop]" :disabled="isDisabled()" />

        <!-- Time -->
        <el-time-picker
            v-else-if="item.component === 'time'"
            v-model="model[item.prop]"
            v-bind="item.componentProps"
            value-format="HH:mm:ss"
            format="HH:mm:ss"
            :disabled="isDisabled()"
        />

        <!-- Date -->
        <el-date-picker
            v-else-if="item.component === 'date'"
            v-model="model[item.prop]"
            type="date"
            value-format="YYYY-MM-DD"
            format="YYYY-MM-DD"
            v-bind="item.componentProps"
            :disabled="isDisabled()"
        />

        <!-- Datetime -->
        <el-date-picker
            v-else-if="item.component === 'datetime'"
            v-model="model[item.prop]"
            type="datetime"
            value-format="YYYY-MM-DD HH:mm:ss"
            format="YYYY-MM-DD HH:mm:ss"
            v-bind="item.componentProps"
            :disabled="isDisabled()"
        />

        <!-- Year -->
        <el-date-picker
            v-else-if="item.component === 'year'"
            v-model="model[item.prop]"
            type="year"
            value-format="YYYY"
            format="YYYY"
            v-bind="item.componentProps"
            :disabled="isDisabled()"
        />

        <!-- Upload：当前项独立的 fileList -->
        <el-upload
            v-if="item.component === 'upload' && item.uploadType === 'image'"
            v-model:file-list="fileList"
            :http-request="uploadRequest"
            :limit="item.componentProps?.limit ?? 1"
            :multiple="item.componentProps?.multiple"
            list-type="picture-card"
            accept="image/*"
            :on-success="handleImageSuccess"
            :on-remove="handleImageRemove"
        >
            <el-icon>
                <Plus />
            </el-icon>
        </el-upload>
        <!-- Rich Text：当前项独立的 editor -->
        <div v-else-if="item.component === 'rich-text'" class="rich-text">
            <Toolbar :editor="editorRef" :default-config="richTextConfig.toolbarConfig" mode="default" />
            <Editor
                v-model="model[item.prop]"
                :default-config="richTextConfig.editorConfig"
                mode="default"
                @on-created="handleEditorCreated"
                @on-destroyed="handleEditorDestroyed"
            />
        </div>
        <!-- FK Select -->
        <RelationSelect
            v-else-if="item.component === 'fk_select'"
            :model-value="model[item.prop]"
            :field="`${item.model}.${item.prop}`"
            :relation-module="item.relationModule"
            :relation-model="item.relationModel"
            :clearable="item.componentProps?.clearable ?? true"
            :placeholder="item.componentProps?.placeholder ?? '请选择'"
            :disabled="isDisabled()"
            @update:model-value="v => (model[item.prop] = v as any)"
        />

        <!-- Morph Select -->
        <RelationSelect
            v-else-if="item.component === 'morph_select'"
            :morph-id="model[getMorphIdProp(item)]"
            :morph-type="model[getMorphTypeProp(item)]"
            :field="getMorphField(item)"
            :polymorphic="true"
            :clearable="item.componentProps?.clearable ?? true"
            :placeholder="item.componentProps?.placeholder ?? '请选择'"
            :disabled="isDisabled()"
            @update:morph-id="v => ((model as any)[getMorphIdProp(item)] = v)"
            @update:morph-type="v => ((model as any)[getMorphTypeProp(item)] = v)"
        />

        <!-- Slot 扩展 -->
        <slot v-else-if="item.component === 'slot'" :name="item.prop" :model="model" :schema="item" />
    </el-form-item>
</template>

<script setup lang="ts" generic="T extends Record<string, any>">
/* eslint-disable @typescript-eslint/no-explicit-any */
import { computed, ref, watch, onBeforeUnmount } from 'vue'
import { Editor, Toolbar } from '@wangeditor/editor-for-vue'
import '@wangeditor/editor/dist/css/style.css'
import type { FormSchemaItem } from '@/components/PopupForm/types'
import type { FormMode } from '@/composables/crud/types'
import type { UploadRequestOptions } from 'element-plus'
import { ElMessage } from 'element-plus'
import { Plus } from '@element-plus/icons-vue'
import http from '@/api/core/client'
import { resolveImageUrl } from '@/utils/media'
import RelationSelect from '@/components/RelationSelect/index.vue'

defineOptions({
    name: 'FormItem'
})

function getMorphIdProp(item: FormSchemaItem<T>): string {
    return `${item.prop}_id`
}

function getMorphTypeProp(item: FormSchemaItem<T>): string {
    return `${item.prop}_type`
}

function getMorphField(item: FormSchemaItem<T>): string {
    return `${item.model}.${item.prop}`
}

const props = defineProps<{
    item: FormSchemaItem<T>
    mode: FormMode
}>()

const model = defineModel<T>('model', { required: true })

const formItemProp = computed(() =>
    props.item.component === 'morph_select' ? getMorphIdProp(props.item) : props.item.prop
)

function isDisabled(): boolean {
    const item = props.item
    if (typeof item.disabled === 'function') {
        return !!item.disabled(props.mode)
    }
    return !!item.disabled
}

// ---------- Upload（当前项独立 fileList）----------
const fileList = ref<any[]>([])

function syncFileListFromModel() {
    if (props.item.component === 'upload' && props.item.uploadType === 'image') {
        const val = model.value[props.item.prop]
        if (!val) {
            fileList.value = []
            return
        }
        const urls: string[] = Array.isArray(val) ? (val as string[]) : [val as string]
        fileList.value = urls.map((url: string) => ({
            name: url.split('/').pop(),
            url: resolveImageUrl(url),
            key: url
        }))
    }
}

watch(
    () => model.value[props.item.prop],
    () => syncFileListFromModel(),
    { immediate: true }
)

interface UploadResponse {
    url?: string
    key?: string
}

async function uploadFile(file: File, filename = 'file', onProgress?: (evt: { percent?: number }) => void) {
    const formData = new FormData()
    formData.append(filename, file)
    const res = await http.post<UploadResponse, UploadResponse>('/upload', formData, {
        headers: { 'Content-Type': 'multipart/form-data' },
        onUploadProgress: e => {
            if (!e.total) return
            onProgress?.({ percent: Math.round((e.loaded / e.total) * 100) })
        }
    })
    return res
}

const uploadRequest = async (options: UploadRequestOptions) => {
    const res = await uploadFile(options.file, options.filename, options.onProgress as any)
    options.onSuccess(res)
}

function isMultiple(): boolean {
    if (props.item.componentProps?.multiple === true) return true
    if (typeof props.item.componentProps?.limit === 'number') {
        return props.item.componentProps.limit > 1
    }
    return false
}

interface ImageUploadResponse {
    url: string
    key: string
}

function handleImageSuccess(response: ImageUploadResponse) {
    // el-upload on-success: (response, uploadFile, uploadFiles)，response 来自 http-request 的 onSuccess
    const key = response?.key ?? response?.url
    if (!key) return
    const prop = props.item.prop
    const multiple = isMultiple()
    if (multiple) {
        if (!Array.isArray((model.value as any)[prop])) {
            ;(model.value as any)[prop] = []
        }
        ;((model.value as any)[prop] as string[]).push(key)
    } else {
        ;(model.value as any)[prop] = key
    }
}

function handleImageRemove(_: any, uploadFileList: any[]) {
    const prop = props.item.prop
    const multiple = isMultiple()
    ;(model.value as any)[prop] = multiple
        ? (uploadFileList ?? []).map((f: any) => f.key ?? f.response?.key)
        : undefined
}

// ---------- Rich Text（当前项独立 editor）----------
const editorRef = ref<any>(null)
const richTextDefaultInit = {
    placeholder: '请输入内容',
    readOnly: false
}

async function handleWangUpload(file: File, insertFn: (url: string) => void) {
    try {
        const res = await uploadFile(file)
        const raw = res?.url ?? res?.key
        const url = raw ? resolveImageUrl(raw) : ''
        if (!url) throw new Error('Upload response missing url')
        insertFn(url)
    } catch (err) {
        ElMessage.error('上传失败')
        console.error(err)
    }
}

const richTextConfig = computed(() => {
    const item = props.item
    const { toolbarConfig, editorConfig, ...rest } = item.componentProps ?? {}
    const menuConf = editorConfig?.MENU_CONF ?? {}
    const readOnly = isDisabled() ?? false

    return {
        ...rest,
        toolbarConfig: { ...(toolbarConfig ?? {}) },
        editorConfig: {
            ...richTextDefaultInit,
            ...(editorConfig ?? {}),
            readOnly: readOnly || editorConfig?.readOnly === true,
            MENU_CONF: {
                uploadImage: {
                    customUpload: async (file: File, insertFn: (url: string) => void) => {
                        await handleWangUpload(file, insertFn)
                    }
                },
                uploadVideo: {
                    customUpload: async (file: File, insertFn: (url: string) => void) => {
                        await handleWangUpload(file, insertFn)
                    }
                },
                ...menuConf
            }
        }
    }
})

function handleEditorCreated(editor: any) {
    editorRef.value = editor
}

function handleEditorDestroyed() {
    editorRef.value = undefined
}

onBeforeUnmount(() => {
    if (editorRef.value) {
        try {
            editorRef.value.destroy()
        } catch {
            // ignore
        }
    }
})
</script>

<style scoped>
.rich-text {
    width: 100%;
    border: 1px solid #ccc;
    min-height: 300px;
}
</style>
