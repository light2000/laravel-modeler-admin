<template>
  <div class="table-box">
    <!-- Search -->
    <SearchForm v-model:query="list.query" :schema="administratorSearchSchema" :reload="list.reload" />
    <!-- Table -->
    <ProTable
v-model:query="list.query" :columns="administratorTableSchema" selectable :loading="list.loading" :rows="list.rows"
      :total="list.total" :reload="list.reload">
      <!-- toolbar -->
      <template #toolbar="scope">
        <el-button v-can="'user.administrator.store'" type="primary" :icon="CirclePlus" @click="form.openCreate()">
          新增管理员
        </el-button>
        <el-button v-can="'user.administrator.destroy'" type="danger" :icon="Delete" plain :disabled="!scope.isSelected">
          批量删除
        </el-button>
      </template>

      <!-- operation -->
      <template #operation="{ row }">
        <el-button v-can="'user.administrator.update'" type="primary" link :icon="EditPen" @click="form.openUpdate(row.id)">编辑</el-button>
        <el-button v-can="'user.administrator.destroy'" link type="danger" :icon="Delete" @click="del.execute(row.id)">删除</el-button>
        <el-button v-can="'user.administrator.show'" link type="primary" :icon="View" @click="detail.open(row.id)">详情</el-button>
      </template>
    </ProTable>
    <!-- Dialog Form -->
    <PopupForm
v-model:visible="form.visible" :mode="form.mode" :schema="administratorFormSchema" :record="form.record"
      :title="form.title" :errors="form.errors" @submit="form.submit"/>
    <PopupDetail
v-model:visible="detail.visible" type="dialog" :title="detail.title" :schema="administratorDetailSchema"
      :data="detail.record" :column="2" />
  </div>
</template>
<script setup lang="ts">
import { CirclePlus, Delete, EditPen, View } from '@element-plus/icons-vue';
import SearchForm from '@/components/SearchForm/index.vue';
import ProTable from '@/components/ProTable/index.vue'
import PopupForm from '@/components/PopupForm/index.vue'
import PopupDetail from '@/components/PopupDetail/index.vue'
import { administratorApi } from '@/api/modules/user/administrator.api'
import { administratorSearchSchema, administratorTableSchema, administratorFormSchema, administratorDetailSchema } from './schemas'
import { useCrud } from '@/composables/crud/useCrud'


defineOptions({
  name: 'AdministratorIndex',
})

const {
  list,
  form,
  del,
  detail
} = useCrud(administratorApi)
</script>

<style scoped></style>