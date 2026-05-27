<template>
  <div class="table-box">
    <SearchForm v-model:query="list.query" :schema="categorySearchSchema" :reload="list.reload" />
    <ProTable
      v-model:query="list.query"
      :columns="categoryTableSchema"
      selectable
      :loading="list.loading"
      :rows="list.rows"
      :total="list.total"
      :reload="list.reload"
    >
      <template #toolbar="scope">
        <el-button v-can="'shop.category.store'" type="primary" :icon="CirclePlus" @click="form.openCreate()">
          新增分类
        </el-button>
        <el-button
          v-can="'shop.category.destroy'"
          type="danger"
          :icon="Delete"
          plain
          :disabled="!scope.isSelected"
          @click="del.execute(scope.selectedIds)"
        >
          批量删除
        </el-button>
      </template>
      <template #operation="{ row }">
        <el-button v-can="'shop.category.update'" type="primary" link :icon="EditPen" @click="form.openUpdate(row.id)">编辑</el-button>
        <el-button v-can="'shop.category.destroy'" link type="danger" :icon="Delete" @click="del.execute(row.id)">删除</el-button>
        <el-button v-can="'shop.category.show'" link type="primary" :icon="View" @click="detail.open(row.id)">详情</el-button>
      </template>
    </ProTable>
    <PopupForm
      v-model:visible="form.visible"
      :mode="form.mode"
      :schema="categoryFormSchema"
      :record="form.record"
      :title="form.title"
      :errors="form.errors"
      @submit="form.submit"
    />
    <PopupDetail
      v-model:visible="detail.visible"
      type="dialog"
      :title="detail.title"
      :schema="categoryDetailSchema"
      :data="detail.record"
      :column="2"
    />
  </div>
</template>
<script setup lang="ts">
import { CirclePlus, Delete, EditPen, View } from '@element-plus/icons-vue';
import SearchForm from '@/components/SearchForm/index.vue';
import ProTable from '@/components/ProTable/index.vue'
import PopupForm from '@/components/PopupForm/index.vue'
import PopupDetail from '@/components/PopupDetail/index.vue'
import { categoryApi } from '@/api/modules/shop/category.api'
import { categorySearchSchema, categoryTableSchema, categoryFormSchema, categoryDetailSchema } from './schemas'
import { useCrud } from '@/composables/crud/useCrud'

defineOptions({
  name: 'ShopCategoryIndex',
})

const { list, form, del, detail } = useCrud(categoryApi)
</script>

<style scoped></style>
