<template>
    <div class="tabs-box">
        <div class="tabs-menu">
            <el-tabs v-model="tabsValue" type="card" @tab-click="tabClick" @tab-remove="tabRemove">
                <el-tab-pane
                    v-for="item in tabs"
                    :key="item.fullPath"
                    :label="item.meta.title"
                    :name="item.fullPath"
                    :closable="!item.meta?.affix"
                >
                    <template #label>
                        <Icon v-if="item.meta?.icon" :name="item.meta.icon as string" class="tabs-icon" />
                        {{ item.meta?.title }}
                    </template>
                </el-tab-pane>
            </el-tabs>
            <MoreButton />
        </div>
    </div>
</template>

<script setup lang="ts">
import { ref, computed, watch } from 'vue'
import { useRoute, useRouter } from 'vue-router'
import { useTabsStore } from '@/store/modules/tabs'
import Icon from '@/components/Icon/index.vue'
import MoreButton from './components/MoreButton.vue'
import type { TabPaneName, TabsPaneContext } from 'element-plus'

defineOptions({
    name: 'ScaffTabs'
})

const route = useRoute()
const router = useRouter()
const tabsStore = useTabsStore()

const tabsValue = ref(route.fullPath)
const tabs = computed(() => tabsStore.visitedViews)

// 监听路由的变化（防止浏览器后退/前进不变化 tabsMenuValue）
watch(
    () => route.fullPath,
    path => {
        tabsValue.value = path
        tabsStore.addView(route)
        console.log(tabs.value)
    },
    { immediate: true }
)
// Tab Click
const tabClick = (tabItem: TabsPaneContext) => {
    const fullPath = tabItem.props.name as string
    router.push(fullPath)
}

// Remove Tab
const tabRemove = (fullPath: TabPaneName) => {
    const view = tabs.value.find(item => item.fullPath === fullPath) || null
    if (!view) return
    const isActive = tabsValue.value === fullPath
    tabsStore.delView(view)
    if (isActive) {
        const last = tabs.value[tabs.value.length - 1]
        if (last) router.push(last.fullPath)
        else router.push('/')
    }
}
</script>

<style scoped lang="scss">
@use './index';
</style>
