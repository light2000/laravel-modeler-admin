<!-- 经典布局 -->
<template>
    <el-container class="layout">
        <el-header>
            <div class="header-lf mask-image">
                <div class="logo flx-center">
                    <img class="logo-img" src="@/assets/images/logo.svg" alt="logo" />
                    <span class="logo-text">{{ title }}</span>
                </div>
                <ToolBarLeft />
            </div>
            <div class="header-ri">
                <ToolBarRight />
            </div>
        </el-header>
        <el-container class="classic-content">
            <el-aside>
                <div class="aside-box" :style="{ width: isCollapse ? '65px' : '210px' }">
                    <el-scrollbar>
                        <el-menu
                            :router="false"
                            :default-active="activeMenu"
                            :collapse="isCollapse"
                            :unique-opened="false"
                            :collapse-transition="false"
                        >
                            <SubMenu :menu-list="menuList" />
                        </el-menu>
                    </el-scrollbar>
                </div>
            </el-aside>
            <el-container class="classic-main">
                <Main />
            </el-container>
        </el-container>
    </el-container>
</template>

<script setup lang="ts">
import { computed } from 'vue'
import { useRoute } from 'vue-router'
import Main from '@/layouts/components/Main/index.vue'
import SubMenu from '@/layouts/components/Menu/SubMenu.vue'
import ToolBarLeft from '@/layouts/components/Header/ToolBarLeft.vue'
import ToolBarRight from '@/layouts/components/Header/ToolBarRight.vue'
import { useAppStore } from '@/store/modules/app'
import { usePermissionStore } from '@/store/modules/permission'

defineOptions({
    name: 'ScaffLayoutClassic'
})

const title = import.meta.env.VITE_APP_NAME

const route = useRoute()
const permissionStore = usePermissionStore()
const appStore = useAppStore()
const isCollapse = computed(() => appStore.collapse)
const menuList = computed(() => permissionStore.menus)
const activeMenu = computed(() => (route.meta.activeMenu ? route.meta.activeMenu : route.path) as string)
</script>

<style scoped lang="scss">
@use './index';
</style>
