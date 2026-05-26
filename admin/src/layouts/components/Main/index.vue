<template>
    <Tabs v-if="appStore.tabs" />
    <el-main>
        <router-view v-slot="{ Component }">
            <transition appear name="fade-transform" mode="out-in">
                <keep-alive :include="tabsStore.getCachedViews">
                    <component :is="Component" />
                </keep-alive>
            </transition>
        </router-view>
    </el-main>
    <el-footer>
        <Footer />
    </el-footer>
</template>

<script setup lang="ts">
import { watch } from 'vue'
import { useAppStore } from '@/store/modules/app'
import { useTabsStore } from '@/store/modules/tabs'
import Tabs from '@/layouts/components/Tabs/index.vue'
import Footer from '@/layouts/components/Footer/index.vue'

defineOptions({
    name: 'ScaffMain'
})

const appStore = useAppStore()
const tabsStore = useTabsStore()

// 监听布局变化，在 body 上添加相对应的 layout class
watch(
    () => appStore.layout,
    () => {
        const body = document.body
        body.setAttribute('class', appStore.layout)
    },
    { immediate: true }
)
</script>

<style scoped lang="scss">
.el-main {
    box-sizing: border-box;
    padding: 10px 12px;
    overflow-x: hidden;
    background-color: var(--el-bg-color-page);
}

.el-footer {
    height: auto;
    padding: 0;
}
</style>
