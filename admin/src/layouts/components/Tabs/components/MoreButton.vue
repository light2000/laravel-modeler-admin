<template>
    <el-dropdown trigger="click" :teleported="false">
        <div class="more-button">
            <Icon name="ant-design:setting-outlined" size="18" />
        </div>
        <template #dropdown>
            <el-dropdown-menu>
                <el-dropdown-item @click="refresh">
                    <Icon name="ep:Refresh" />
                    {{ $t('tabs.refresh') }}
                </el-dropdown-item>
                <el-dropdown-item divided @click="closeOtherTab">
                    <Icon name="ep:CircleClose" />
                    {{ $t('tabs.closeOther') }}
                </el-dropdown-item>
                <el-dropdown-item @click="closeAllTab">
                    <Icon name="ep:FolderDelete" />
                    {{ $t('tabs.closeAll') }}
                </el-dropdown-item>
            </el-dropdown-menu>
        </template>
    </el-dropdown>
</template>

<script setup lang="ts">
import { useTabsStore } from '@/store/modules/tabs'
import { useRoute, useRouter } from 'vue-router'
import Icon from '@/components/Icon/index.vue'
const route = useRoute()
const router = useRouter()
const tabsStore = useTabsStore()

// refresh current page
const refresh = () => {
    tabsStore.refreshView(route)
}

// Close Other
const closeOtherTab = () => {
    tabsStore.delOthersViews(route)
}

// Close All
const closeAllTab = () => {
    tabsStore.delAllViews()
    router.push({ name: 'Dashboard' })
}
</script>

<style scoped lang="scss">
@use '../index.scss';
</style>
