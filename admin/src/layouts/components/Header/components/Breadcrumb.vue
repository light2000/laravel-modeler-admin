<template>
    <div :class="['breadcrumb-box mask-image']">
        <el-breadcrumb>
            <transition-group name="breadcrumb">
                <el-breadcrumb-item v-for="(item, index) in breadcrumbList" :key="item.path">
                    <div
                        class="el-breadcrumb__inner is-link"
                        @click="onBreadcrumbClick(item as MenuItem, index as number)"
                    >
                        <Icon v-if="item.meta?.icon" :name="item.meta.icon" class="breadcrumb-icon" />
                        <span class="breadcrumb-title">{{ item.meta.title }}</span>
                    </div>
                </el-breadcrumb-item>
            </transition-group>
        </el-breadcrumb>
    </div>
</template>

<script setup lang="ts">
import { computed } from 'vue'
import { useRoute, useRouter } from 'vue-router'

import Icon from '@/components/Icon/index.vue'
import { MenuItem, usePermissionStore } from '@/store/modules/permission'

defineOptions({
    name: 'ScaffBreadcrumb'
})

const route = useRoute()
const router = useRouter()
const permissionStore = usePermissionStore()

const breadcrumbList = computed(() => {
    const path = route.matched[route.matched.length - 1].path
    let breadcrumbData = permissionStore.breadcrumbMap[path] ?? []
    if (route.matched[route.matched.length - 1].name !== 'Home') {
        breadcrumbData = [{ path: '/', meta: { icon: 'ep:HomeFilled', title: '首页' } }, ...breadcrumbData]
    } else {
        breadcrumbData = [{ path: '/', meta: { icon: 'ep:HomeFilled', title: '首页' } }]
    }

    return breadcrumbData
})

// Click Breadcrumb
const onBreadcrumbClick = (item: MenuItem, index: number) => {
    if (index !== breadcrumbList.value.length - 1) router.push(item.path)
}
</script>

<style scoped lang="scss">
.breadcrumb-box {
    display: flex;
    align-items: center;
    overflow: hidden;

    .el-breadcrumb {
        white-space: nowrap;

        .el-breadcrumb__item {
            position: relative;
            display: inline-block;
            float: none;

            .el-breadcrumb__inner {
                display: inline-flex;

                &.is-link {
                    color: var(--el-header-text-color);

                    &:hover {
                        color: var(--el-color-primary);
                    }
                }

                .breadcrumb-icon {
                    margin-top: 2px;
                    margin-right: 6px;
                    font-size: 16px;
                }

                .breadcrumb-title {
                    margin-top: 3px;
                }
            }

            &:last-child .el-breadcrumb__inner,
            &:last-child .el-breadcrumb__inner:hover {
                color: var(--el-header-text-color-regular);
            }

            :deep(.el-breadcrumb__separator) {
                position: relative;
                top: -1px;
            }
        }
    }
}

.no-icon {
    .el-breadcrumb {
        .el-breadcrumb__item {
            top: -2px;

            :deep(.el-breadcrumb__separator) {
                top: 2px;
            }
        }
    }
}
</style>
