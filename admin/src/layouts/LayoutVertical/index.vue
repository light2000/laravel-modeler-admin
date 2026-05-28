<!-- 纵向布局 -->
<template>
    <el-container class="layout">
        <el-aside>
            <div class="aside-box" :style="{ width: isCollapse ? '65px' : '210px' }">
                <div class="logo flx-center">
                    <img class="logo-img" src="@/assets/images/logo.svg" alt="logo" />
                    <span v-show="!isCollapse" class="logo-text">{{ title }}</span>
                </div>
                <el-scrollbar>
                    <el-menu
                        :router="false"
                        :default-active="activeMenu"
                        :collapse="isCollapse"
                        :collapse-transition="false"
                    >
                        <el-menu-item v-if="homeRoute" :index="homeRoute.path" @click="handleClickHome">
                            <Icon v-if="homeRoute.meta?.icon" :name="homeRoute.meta.icon as string" />
                            <template #title>
                                <span class="sle">{{ homeRoute.meta?.title || '' }}</span>
                            </template>
                        </el-menu-item>
                        <SubMenu :menu-list="menuList" />
                    </el-menu>
                </el-scrollbar>
            </div>
        </el-aside>
        <el-container>
            <el-header>
                <ToolBarLeft />
                <ToolBarRight />
            </el-header>
            <Main />
        </el-container>
    </el-container>
</template>

<script setup lang="ts">
import { computed } from 'vue'
import { useRoute, useRouter } from 'vue-router'
import Icon from '@/components/Icon/index.vue'
import Main from '@/layouts/components/Main/index.vue'
import ToolBarLeft from '@/layouts/components/Header/ToolBarLeft.vue'
import ToolBarRight from '@/layouts/components/Header/ToolBarRight.vue'
import SubMenu from '@/layouts/components/Menu/SubMenu.vue'
import { useAppStore } from '@/store/modules/app'
import { usePermissionStore } from '@/store/modules/permission'

defineOptions({
    name: 'ScaffLayoutVertical'
})

const title = import.meta.env.VITE_APP_NAME

const route = useRoute()
const router = useRouter()
const appStore = useAppStore()
const permissionStore = usePermissionStore()
const homeRoute = computed(() => {
    const routes = router.getRoutes()
    return routes.find(item => item.name === 'Dashboard')
})

const handleClickHome = () => {
    if (!homeRoute.value) return
    router.push(homeRoute.value.path)
}
const isCollapse = computed(() => appStore.collapse)
const menuList = computed(() => permissionStore.menus)
const activeMenu = computed(() => (route.meta.activeMenu ? route.meta.activeMenu : route.path) as string)
</script>

<style scoped lang="scss">
@use './index';
</style>
