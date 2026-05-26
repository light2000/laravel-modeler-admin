<template>
    <!-- text -->
    <template v-if="field.type === 'text'">
        <el-tag v-if="field.render === 'tag'">
            {{ value }}
        </el-tag>
        <span v-else>
            {{ value }}
        </span>
    </template>

    <!-- boolean -->
    <template v-else-if="field.type === 'boolean'">
        <el-switch v-if="field.render === 'switch'" :model-value="Boolean(value)" disabled />
        <el-tag v-else-if="field.render === 'tag'" :type="Boolean(value) ? 'success' : 'info'">
            {{ Boolean(value) ? (field.trueLabel ?? '是') : (field.falseLabel ?? '否') }}
        </el-tag>
        <span v-else>
            {{ Boolean(value) ? (field.trueLabel ?? '是') : (field.falseLabel ?? '否') }}
        </span>
    </template>

    <!-- enum -->
    <template v-else-if="field.type === 'enum'">
        <template v-if="field.multiple === true">
            <template v-if="field.render === 'tag'">
                <el-tag v-for="label in getEnumLabels(field, value)" :key="label" style="margin-right: 6px">
                    {{ label }}
                </el-tag>
            </template>
            <span v-else>
                {{ getEnumLabels(field, value).join(field.separator ?? ', ') }}
            </span>
        </template>
        <template v-else>
            <el-tag v-if="field.render === 'tag'">
                {{ getEnumLabel(field, value) }}
            </el-tag>
            <span v-else>
                {{ getEnumLabel(field, value) }}
            </span>
        </template>
    </template>

    <!-- image -->
    <template v-else-if="field.type === 'image'">
        <el-image
            :src="getImageSrc(value)"
            :style="{ width: `${field.size ?? 40}px`, height: `${field.size ?? 40}px` }"
            :preview-src-list="getImagePreviewSrcList(field.preview, value)"
            :preview-teleported="true"
            :z-index="5000"
            fit="cover"
        />
    </template>

    <!-- images -->
    <template v-else-if="field.type === 'images'">
        <template v-if="getStringArray(value).length > 0">
            <div class="field-value-media-list">
                <el-image
                    v-for="src in getStringArray(value).slice(0, field.max ?? 3)"
                    :key="src"
                    :src="resolveImageUrl(src) ?? ''"
                    :style="{ width: `${field.size ?? 40}px`, height: `${field.size ?? 40}px` }"
                    :preview-src-list="getImagesPreviewSrcList(field.preview, value)"
                    :preview-teleported="true"
                    :z-index="5000"
                    fit="cover"
                />
            </div>
        </template>
        <span v-else>
            {{ field.emptyText ?? '-' }}
        </span>
    </template>

    <!-- avatar -->
    <template v-else-if="field.type === 'avatar'">
        <el-avatar :src="getImageSrc(value)" :size="field.size ?? 40" :shape="field.shape ?? 'circle'" />
    </template>

    <!-- avatars -->
    <template v-else-if="field.type === 'avatars'">
        <template v-if="getStringArray(value).length > 0">
            <div class="field-value-media-list">
                <el-avatar
                    v-for="src in getStringArray(value).slice(0, field.max ?? 3)"
                    :key="src"
                    :src="resolveImageUrl(src) ?? ''"
                    :size="field.size ?? 40"
                />
            </div>
        </template>
        <span v-else>
            {{ field.emptyText ?? '-' }}
        </span>
    </template>
    <!-- fk_display -->
    <template v-else-if="field.type === 'fk'">
        <span>
            {{
                typeof value === 'object' && value !== null
                    ? Object.values(value).join(field.separator ?? '-')
                    : (value ?? field.emptyText ?? '-')
            }}
        </span>
    </template>

    <!-- rich-text -->
    <template v-else-if="field.type === 'rich-text'">
        <div class="field-value-rich-text" v-html="value"></div>
    </template>

    <!-- fallback -->
    <span v-else>
        {{ value }}
    </span>
</template>

<script setup lang="ts" generic="R">
import { ElAvatar, ElImage, ElSwitch, ElTag } from 'element-plus'
import type { FieldConfig, EnumFieldConfig } from './types'
import { getOptionLabel, getOptions } from '@/meta/enums.utils'
import { resolveImageUrl } from '@/utils/media'

defineOptions({
    name: 'ScaffFieldValue'
})

defineProps<{
    field: FieldConfig<R>
    // eslint-disable-next-line @typescript-eslint/no-explicit-any
    value: any
    row?: R
}>()

function getEnumOptions(field: EnumFieldConfig<R>) {
    return 'options' in field ? field.options : getOptions(field.enumKey)
}

function getEnumLabel(field: EnumFieldConfig<R>, value: unknown) {
    const options = getEnumOptions(field)
    const normalized = typeof value === 'string' || typeof value === 'number' ? value : String(value ?? '')
    return getOptionLabel(options ?? [], normalized)
}

function getEnumLabels(field: EnumFieldConfig<R>, value: unknown): string[] {
    const options = getEnumOptions(field)
    const values = getEnumValues(value)
    return values.map(v => getOptionLabel(options ?? [], v)).filter(label => label.length > 0)
}

function getEnumValues(value: unknown): Array<string | number> {
    if (Array.isArray(value)) {
        return value.filter((v): v is string | number => typeof v === 'string' || typeof v === 'number')
    }
    if (typeof value === 'string' || typeof value === 'number') return [value]
    return []
}

function getStringArray(value: unknown): string[] {
    if (Array.isArray(value)) return value.filter((v): v is string => typeof v === 'string' && v.length > 0)
    if (typeof value === 'string') return value.length > 0 ? [value] : []
    return []
}

function getImageSrc(value: unknown): string {
    const raw = typeof value === 'string' ? value : ''
    return resolveImageUrl(raw) ?? ''
}

function getImagePreviewSrcList(preview: boolean | undefined, value: unknown): string[] {
    if (preview === false) return []
    const src = getImageSrc(value)
    return src.length > 0 ? [src] : []
}

function getImagesPreviewSrcList(preview: boolean | undefined, value: unknown): string[] {
    if (preview === false) return []
    return getStringArray(value)
        .map(src => resolveImageUrl(src) ?? '')
        .filter(src => src.length > 0)
}
</script>

<style scoped>
.field-value-media-list {
    display: flex;
    align-items: center;
    gap: 6px;
    flex-wrap: nowrap;
}
</style>
