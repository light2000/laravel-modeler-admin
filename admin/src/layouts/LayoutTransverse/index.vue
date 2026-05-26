<!-- 横向布局 -->
<template>
    <el-container class="layout">
        <el-header>
            <div class="logo flx-center">
                <img class="logo-img" src="@/assets/images/logo.svg" alt="logo" />
                <span class="logo-text">{{ title }}</span>
            </div>
            <el-menu mode="horizontal" :router="false" :default-active="activeMenu">
                <!-- 不能直接使用 SubMenu 组件，无法触发 el-menu 隐藏省略功能 -->
                <template v-for="subItem in menuList" :key="subItem.path">
                    <el-sub-menu
                        v-if="subItem.children?.length"
                        :key="subItem.path"
                        :index="subItem.path + 'el-sub-menu'"
                    >
                        <template #title>
                            <Icon v-if="subItem.meta?.icon" :name="subItem.meta.icon as string" />
                            <span>{{ subItem.meta?.title }}</span>
                        </template>
                        <SubMenu :menu-list="subItem.children" />
                    </el-sub-menu>
                    <el-menu-item
                        v-else
                        :key="subItem.path + 'el-menu-item'"
                        :index="subItem.path"
                        @click="handleClickMenu(subItem)"
                    >
                        <Icon v-if="subItem.meta?.icon" :name="subItem.meta.icon as string" />
                        <template #title>
                            <span>{{ subItem.meta?.title }}</span>
                        </template>
                    </el-menu-item>
                </template>
            </el-menu>
            <ToolBarRight />
        </el-header>
        <Main />
    </el-container>
</template>

<script setup lang="ts">
import { computed } from 'vue'
import { useRoute, useRouter } from 'vue-router'
import Main from '@/layouts/components/Main/index.vue'
import ToolBarRight from '@/layouts/components/Header/ToolBarRight.vue'
import SubMenu from '@/layouts/components/Menu/SubMenu.vue'
import { usePermissionStore } from '@/store/modules/permission'
import type { MenuItem } from '@/store/modules/permission'
import Icon from '@/components/Icon/index.vue'
defineOptions({
    name: 'ScaffLayoutTransverse'
})

const title = import.meta.env.VITE_APP_NAME

const route = useRoute()
const router = useRouter()
const permissionStore = usePermissionStore()
const menuList = computed(() => permissionStore.menus)
const activeMenu = computed(() => (route.meta.activeMenu ? route.meta.activeMenu : route.path) as string)

const handleClickMenu = (subItem: MenuItem) => {
    router.push(subItem.path)
}
</script>

<style scoped lang="scss">
@use './index';
</style>
