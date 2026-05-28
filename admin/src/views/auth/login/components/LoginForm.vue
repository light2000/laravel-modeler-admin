<template>
    <el-form ref="loginFormRef" :model="loginForm" :rules="loginRules" size="large">
        <el-form-item prop="account">
            <el-input v-model="loginForm.account" placeholder="请输入账号">
                <template #prefix>
                    <Icon name="ep:User" class="el-input__icon" />
                </template>
            </el-input>
        </el-form-item>
        <el-form-item prop="password" style="margin-bottom: 0">
            <el-input
                v-model="loginForm.password"
                type="password"
                placeholder="请输入密码"
                show-password
                autocomplete="new-password"
            >
                <template #prefix>
                    <Icon name="ep:Lock" class="el-input__icon" />
                </template>
            </el-input>
        </el-form-item>
    </el-form>
    <div class="login-btn">
        <el-button :icon="CircleClose" round size="large" @click="resetForm"> 重置 </el-button>
        <el-button :icon="UserFilled" round size="large" type="primary" :loading="loading" @click="login">
            登录
        </el-button>
    </div>
</template>

<script setup lang="ts">
import { useRouter } from 'vue-router'
import Icon from '@/components/Icon/index.vue'
import { loginApi } from '@/api/modules/auth/administrator.api'
import { useAuthStore } from '@/store/modules/auth'
import { useTabsStore } from '@/store/modules/tabs'
import { usePermissionStore } from '@/store/modules/permission'
import { CircleClose, UserFilled } from '@element-plus/icons-vue'
import { appRoutes } from '@/router/routes'
import { onMounted, reactive, ref } from 'vue'
import { ElNotification } from 'element-plus'

defineOptions({
    name: 'ScaffLoginForm'
})

const router = useRouter()
const authStore = useAuthStore()
const tabsStore = useTabsStore()
const permissionStore = usePermissionStore()
const loginFormRef = ref()

const loginRules = reactive({
    account: [{ required: true, message: '请输入账号', trigger: 'blur' }],
    password: [{ required: true, message: '请输入密码', trigger: 'blur' }]
})

const loading = ref(false)

const loginForm = reactive({
    account: 'supper.administrator',
    password: '123'
})

const getTimeStateText = () => {
    const timeNow = new Date()
    const hours = timeNow.getHours()
    if (hours >= 6 && hours <= 10) {
        return `早上好 ⛅`
    }
    if (hours >= 10 && hours <= 14) {
        return `中午好 🌞`
    }
    if (hours >= 14 && hours <= 18) {
        return `下午好 🌞`
    }
    if (hours >= 18 && hours <= 24) {
        return `晚上好 🌛`
    }
    if (hours >= 0 && hours <= 6) {
        return `凌晨好 🌛`
    }
}

const performLogin = async (formData = loginForm) => {
    loading.value = true
    try {
        const response = await loginApi(formData)
        authStore.setToken(response.token)
        authStore.setAdministrator(response.administrator)
        permissionStore.generateMenus(appRoutes, response.permissions)
        tabsStore.delAllViews()

        router.push({ name: 'Dashboard' })
        ElNotification({
            title: getTimeStateText(),
            message: `欢迎登录 ${import.meta.env.VITE_APP_NAME}`,
            type: 'success',
            duration: 3000
        })
    } catch (error) {
        ElNotification({
            title: '登录失败',
            message: error instanceof Error ? error.message : '未知错误',
            type: 'error',
            duration: 3000
        })
    } finally {
        loading.value = false
    }
}

const login = () => {
    if (!loginFormRef.value) {
        return
    }
    loginFormRef.value.validate(async (valid: boolean) => {
        if (!valid) {
            return
        }
        try {
            loading.value = true
            await performLogin({ ...loginForm }) // 执行登录
        } finally {
            loading.value = false
        }
    })
}

const resetForm = () => {
    if (!loginFormRef.value) return
    loginFormRef.value.resetFields()
}

onMounted(() => {
    document.onkeydown = (e: KeyboardEvent) => {
        e = (window.event as KeyboardEvent) || e
        if (e.code === 'Enter' || e.code === 'enter' || e.code === 'NumpadEnter') {
            if (loading.value) return
            login()
        }
    }
})
</script>

<style scoped lang="scss">
@use '../index';
</style>
