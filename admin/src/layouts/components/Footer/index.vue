<template>
    <div class="footer flx-center">
        <a href="/" target="_blank"> {{ name }} v{{ version }} | Copyright © 2025-{{ new Date().getFullYear() }} </a>
    </div>
</template>
<script setup lang="ts">
const version: string = import.meta.env.VITE_APP_VERSION
const name: string = import.meta.env.VITE_APP_NAME

defineOptions({
    name: 'ScaffFooter'
})
</script>
<style scoped lang="scss">
.footer {
    height: 30px;
    background-color: var(--el-bg-color);
    border-top: 1px solid var(--el-border-color-light);

    a {
        font-size: 14px;
        color: var(--el-text-color-secondary);
        text-decoration: none;
        letter-spacing: 0.5px;
    }
}
</style>
