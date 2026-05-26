<template>
    <el-config-provider :locale="elementLocales[locale]">
        <RouterView />
    </el-config-provider>
</template>

<script setup lang="ts">
import { computed, onMounted } from 'vue'
import { useI18n } from 'vue-i18n'
import { elementLocales } from '@/settings/locale'
import { useAppStore } from '@/store/modules/app'
import { useTheme } from '@/composables/web/useTheme'

const i18n = useI18n()
const locale = computed(() => useAppStore().locale)

onMounted(() => {
    i18n.locale.value = locale.value
})

const { initTheme } = useTheme()
initTheme()
</script>
