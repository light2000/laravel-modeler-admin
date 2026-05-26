<template>
    <component :is="LayoutComponents[layout]" />
</template>

<script setup lang="ts">
import { computed } from 'vue'
import LayoutVertical from '@/layouts/LayoutVertical/index.vue'
import LayoutClassic from '@/layouts/LayoutClassic/index.vue'
import LayoutTransverse from '@/layouts/LayoutTransverse/index.vue'
import LayoutColumns from '@/layouts/LayoutColumns/index.vue'
import { useAppStore } from '@/store/modules/app'
defineOptions({
    name: 'ScaffLayout'
})

const LayoutComponents = {
    vertical: LayoutVertical,
    classic: LayoutClassic,
    transverse: LayoutTransverse,
    columns: LayoutColumns
}

const layout = computed(() => useAppStore().layout)
</script>

<style scoped lang="scss">
.layout {
    min-width: 600px;
}
</style>
