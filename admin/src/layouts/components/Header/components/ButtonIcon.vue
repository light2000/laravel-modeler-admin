<template>
    <el-tooltip :placement="tooltipPlacement" :content="tooltipContent" :z-index="zIndex" :disabled="!tooltipContent">
        <el-button class="icon-btn" text quaternary @dblclick.stop @click="emit('click', $event)">
            <div class="icon-box flx-center">
                <slot>
                    <Icon :name="icon" />
                </slot>
            </div>
        </el-button>
    </el-tooltip>
</template>

<script setup lang="ts">
import Icon from '@/components/Icon/index.vue'
import type { ButtonIconProps } from './types'

defineOptions({
    name: 'ScaffButtonIcon',
    inheritAttrs: false
})

withDefaults(defineProps<ButtonIconProps>(), {
    icon: '',
    tooltipContent: '',
    tooltipPlacement: 'bottom',
    zIndex: 98
})

const emit = defineEmits<{
    (e: 'click', ev: MouseEvent): void
}>()
</script>

<style scoped>
.icon-btn {
    padding: 0;
    width: 38px;
    height: 38px;

    .icon-box {
        font-size: 20px;
        cursor: pointer;
    }
}
</style>
