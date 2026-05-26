<template>
    <el-dropdown trigger="click">
        <div class="avatar-box">
            <div class="avatar">
                <img :src="avatarUrl" />
            </div>
            <div class="username">{{ authStore.administrator?.nickname }}</div>
        </div>

        <template #dropdown>
            <el-dropdown-menu>
                <el-dropdown-item @click="openDialog('infoRef')">
                    <Icon name="ep:User" />
                    {{ $t('header.personalData') }}
                </el-dropdown-item>
                <el-dropdown-item @click="openDialog('passwordRef')">
                    <Icon name="ep:Edit" />
                    {{ $t('header.changePassword') }}
                </el-dropdown-item>
                <el-dropdown-item divided @click="logout">
                    <Icon name="ep:SwitchButton" />
                    {{ $t('header.logout') }}
                </el-dropdown-item>
            </el-dropdown-menu>
        </template>
    </el-dropdown>
    <!-- infoDialog -->
    <InfoDialog ref="infoRef" />
    <!-- passwordDialog -->
    <PasswordDialog ref="passwordRef" />
</template>

<script setup lang="ts">
import { ref, computed } from 'vue'
import { useRouter } from 'vue-router'
import { ElMessage, ElMessageBox } from 'element-plus'
import Icon from '@/components/Icon/index.vue'
import { useAuthStore } from '@/store/modules/auth'
import { resolveImageUrl } from '@/utils/media'
import InfoDialog from './InfoDialog.vue'
import PasswordDialog from './PasswordDialog.vue'
import { logoutApi } from '@/api/modules/auth/administrator.api'

defineOptions({
    name: 'ScaffAvatar'
})

const router = useRouter()
const authStore = useAuthStore()

// 退出登录
const logout = () => {
    ElMessageBox.confirm('您是否确认退出登录?', '温馨提示', {
        confirmButtonText: '确定',
        cancelButtonText: '取消',
        type: 'warning'
    }).then(async () => {
        // 1.执行退出登录接口
        await logoutApi().then(() => {
            // 2.清除 Token
            authStore.logout()
            // 3.重定向到登陆页
            router.push({
                name: 'Login',
                replace: true
            })
            ElMessage.success('退出登录成功！')
        })
    })
}

// 打开修改密码和个人信息弹窗
const infoRef = ref<InstanceType<typeof InfoDialog>>()
const passwordRef = ref<InstanceType<typeof PasswordDialog>>()
const openDialog = (ref: string) => {
    if (ref === 'passwordRef') passwordRef.value?.openDialog()
    if (ref === 'infoRef') infoRef.value?.openDialog()
}

const avatarUrl = computed(() => resolveImageUrl(authStore.administrator?.avatar))
</script>

<style scoped lang="scss">
.avatar-box {
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    gap: 10px;

    .avatar {
        width: 25px;
        height: 25px;
        overflow: hidden;
        cursor: pointer;
        border-radius: 50%;

        img {
            width: 100%;
            height: 100%;
        }
    }

    .username {
        font-size: 15px;
        color: var(--el-header-text-color);
    }
}
</style>
