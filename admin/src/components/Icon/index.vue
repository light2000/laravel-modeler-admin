<template>
    <!-- Element Plus Icon -->
    <el-icon v-if="isElementPlusIcon && elIconComponent" :size="size" :color="color">
        <component :is="elIconComponent" />
    </el-icon>

    <!-- Iconify Icon -->
    <IconifyIcon v-else :icon="name" :width="size" :height="size" :color="color" />
</template>

<script setup lang="ts">
import { computed, type Component } from 'vue'
import { Icon as IconifyIcon } from '@iconify/vue'
import * as ElIcons from '@element-plus/icons-vue'

defineOptions({
    name: 'ScaffIcon'
})

const props = withDefaults(
    defineProps<{
        name: string
        size?: number | string
        color?: string
    }>(),
    {
        size: undefined,
        color: undefined
    }
)

/**
 * 是否 Element Plus Icon
 * 约定：ep:Edit / ep:Delete
 */
const isElementPlusIcon = computed(() => props.name.startsWith('ep:'))

const elIconComponent = computed(() => {
    if (!isElementPlusIcon.value) return null
    const iconName = props.name.replace('ep:', '')
    return (ElIcons as Record<string, Component>)[iconName] || null
})
</script>
