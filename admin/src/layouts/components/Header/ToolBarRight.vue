<template>
    <div class="tool-bar-ri">
        <el-space :size="0">
            <ButtonIcon icon="tabler:layout" tooltip-content="布局模式" @click="appStore.switchLayout()" />
            <ButtonIcon icon="ant-design:skin-outlined" tooltip-content="主题颜色" @click="appStore.switchPrimary()" />
            <ButtonIcon :icon="sunnyOrDarkIcon" tooltip-content="暗色模式" @click="appStore.setDark(!appStore.dark)" />
        </el-space>
        <Avatar />
    </div>
</template>

<script setup lang="ts">
import { computed, watch } from 'vue'
import ButtonIcon from './components/ButtonIcon.vue'
import { useAppStore } from '@/store/modules/app'
import { useTheme } from '@/composables/web/useTheme'
import Avatar from './components/Avatar.vue'

defineOptions({
    name: 'ScaffToolBarRight'
})

const appStore = useAppStore()
const { switchDark, changePrimary } = useTheme()
const sunnyOrDarkIcon = computed(() =>
    appStore.dark ? 'material-symbols:sunny' : 'material-symbols:nightlight-rounded'
)

watch(
    () => appStore.dark,
    newVal => {
        //console.log('appStore.dark', newVal)
        switchDark()
    }
)

watch(
    () => appStore.primary,
    newVal => {
        //console.log('appStore.primary', newVal)
        changePrimary(newVal)
    }
)
</script>

<style scoped lang="scss">
.tool-bar-ri {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
}
</style>
