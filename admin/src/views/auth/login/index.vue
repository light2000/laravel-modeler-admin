<template>
    <div class="login-container flx-center">
        <div class="login-box">
            <div class="login-left">
                <img class="login-left-img" src="@/assets/images/login_left3.png" alt="login" />
            </div>
            <div class="login-form">
                <div class="login-logo">
                    <img class="login-icon" src="@/assets/images/logo.svg" alt="" />
                    <h2 class="logo-text">{{ title }}</h2>
                </div>
                <LoginForm />
            </div>
        </div>
    </div>
</template>

<script setup lang="ts">
import LoginForm from '@/views/auth/login/components/LoginForm.vue'

defineOptions({
    name: 'ScaffLogin'
})

const title = import.meta.env.VITE_APP_NAME
</script>

<style scoped lang="scss">
@use './index';
</style>
