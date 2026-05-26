<template>
    <div class="card table-main">
        <!-- ToolBar 插槽 -->
        <div class="table-header">
            <div class="header-button-lf">
                <slot
                    name="toolbar"
                    :selected-ids="selectedRowKeys"
                    :selected-list="selectedRows"
                    :is-selected="selectedRowKeys.length > 0"
                />
            </div>
            <div class="header-button-ri">
                <slot name="toolButton">
                    <el-button :icon="Refresh" circle @click="reload" />
                </slot>
            </div>
        </div>

        <!-- Table -->
        <el-table v-loading="loading" :border="true" :data="rows" row-key="id" @selection-change="onSelectionChange">
            <!-- selection -->
            <el-table-column v-if="hasSelection" type="selection" width="50" />

            <!-- columns -->
            <template v-for="col in columns" :key="col.prop">
                <el-table-column
                    v-if="!col.slot && 'type' in col"
                    :prop="col.prop"
                    :label="col.label"
                    :width="col.width"
                    :min-width="col.minWidth"
                    :sortable="col.sortable"
                >
                    <template #default="{ row }">
                        <FieldValue :field="col" :value="row[col.prop]" :row="row" />
                    </template>
                </el-table-column>

                <!-- slot column -->
                <el-table-column v-else-if="col.slot" :label="col.label" :width="col.width" :min-width="col.minWidth">
                    <template #default="{ row }">
                        <slot :name="col.slot" :row="row" />
                    </template>
                </el-table-column>
            </template>

            <!-- 无数据 -->
            <template #empty>
                <div class="table-empty">
                    <slot name="empty">
                        <img src="@/assets/images/notData.png" alt="notData" />
                        <div>暂无数据</div>
                    </slot>
                </div>
            </template>
        </el-table>

        <!-- Pagination -->
        <el-pagination
            background
            layout="total, sizes, prev, pager, next"
            :total="total"
            :current-page="query.page || 1"
            :page-size="query.page_size ? parseInt(query.page_size) : 10"
            :page-sizes="[10, 25, 50, 100]"
            @current-change="setPage"
            @size-change="setPageSize"
        />
    </div>
</template>

<script setup lang="ts" generic="P extends BaseQuery, R extends { id: string | number }">
/* eslint-disable @typescript-eslint/no-explicit-any */
import { computed, ref, type UnwrapRef } from 'vue'
import { ElButton, ElPagination, ElTable, ElTableColumn } from 'element-plus'
import { Refresh } from '@element-plus/icons-vue'
import type { TableColumn } from './types'
import type { BaseQuery } from '@/composables/crud/types'
import FieldValue from '@/components/FieldValue/index.vue'

defineOptions({
    name: 'ScaffProTable'
})

defineSlots<{
    toolbar?: (scope: { selectedIds: (string | number)[]; selectedList: UnwrapRef<R[]>; isSelected: boolean }) => any

    operation?: (scope: { row: R }) => any
    empty?: () => any
    toolButton?: () => any
}>()

const props = defineProps<{
    loading: boolean
    columns: TableColumn<R>[]
    rows: R[]
    total: number
    reload: () => void
    selectable?: boolean
}>()

const query = defineModel<P>('query', { required: true })

const emit = defineEmits<{
    (e: 'selection-change', rows: R[]): void
}>()

const hasSelection = computed(() => props.selectable === true)

const selectedRows = ref<R[]>([])
const selectedRowKeys = ref<(string | number)[]>([])
function onSelectionChange(rows: R[]) {
    const keys = rows.map(r => r.id)
    selectedRows.value = rows
    selectedRowKeys.value = keys
    emit('selection-change', rows)
}

const setPage = (page: number) => {
    query.value.page = page
}

const setPageSize = (pageSize: number) => {
    query.value.page_size = pageSize.toString() as '10' | '25' | '50' | '100'
    query.value.page = 1
}
</script>
