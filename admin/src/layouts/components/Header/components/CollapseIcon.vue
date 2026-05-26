<template>
    <Icon
        class="collapse-icon"
        :name="appStore.collapse ? 'ep:Expand' : 'ep:Fold'"
        @click="appStore.setCollapse(!appStore.collapse)"
    />
</template>

<script setup lang="ts">
import { useAppStore } from '@/store/modules/app'
import Icon from '@/components/Icon/index.vue'

defineOptions({
    name: 'ScaffCollapseIcon'
})

const appStore = useAppStore()
</script>
<style scoped lang="scss">
.collapse-icon {
    margin-right: 20px;
    font-size: 22px;
    color: var(--el-header-text-color);
    cursor: pointer;
}
</style>
