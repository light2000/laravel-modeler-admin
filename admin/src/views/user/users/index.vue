<template>
  <div class="table-box">
    <!-- Search -->
    <SearchForm v-model:query="list.query" :schema="userSearchSchema" :reload="list.reload" />
    <!-- Table -->
    <ProTable
v-model:query="list.query" :columns="userTableSchema" selectable :loading="list.loading" :rows="list.rows"
      :total="list.total" :reload="list.reload">
      <!-- toolbar -->
      <template #toolbar="scope">
        <el-button v-can="'user.user.store'" type="primary" :icon="CirclePlus" @click="form.openCreate()">
          新增用户
        </el-button>
        <el-button
          v-can="'user.user.destroy'"
          type="danger"
          :icon="Delete"
          plain
          :disabled="!scope.isSelected"
          @click="del.execute(scope.selectedIds)"
        >
          批量删除
        </el-button>
      </template>

      <!-- operation -->
      <template #operation="{ row }">
        <el-button v-can="'user.user.update'" type="primary" link :icon="EditPen" @click="form.openUpdate(row.id)">编辑</el-button>
        <el-button v-can="'user.user.destroy'" link type="danger" :icon="Delete" @click="del.execute(row.id)">删除</el-button>
        <el-button v-can="'user.user.show'" link type="primary" :icon="View" @click="detail.open(row.id)">详情</el-button>
      </template>
    </ProTable>
    <!-- Dialog Form -->
    <PopupForm
v-model:visible="form.visible" :mode="form.mode" :schema="userFormSchema" :record="form.record"
      :title="form.title" :errors="form.errors" @submit="form.submit"/>
    <PopupDetail
v-model:visible="detail.visible" type="dialog" :title="detail.title" :schema="userDetailSchema"
      :data="detail.record" :column="2" />
  </div>
</template>
<script setup lang="ts">
import { CirclePlus, Delete, EditPen, View } from '@element-plus/icons-vue';
import SearchForm from '@/components/SearchForm/index.vue';
import ProTable from '@/components/ProTable/index.vue'
import PopupForm from '@/components/PopupForm/index.vue'
import PopupDetail from '@/components/PopupDetail/index.vue'
import { userApi } from '@/api/modules/user/user.api'
import { userSearchSchema, userTableSchema, userFormSchema, userDetailSchema } from './schemas'
import { useCrud } from '@/composables/crud/useCrud'


defineOptions({
  name: 'UserIndex',
})

const {
  list,
  form,
  del,
  detail
} = useCrud(userApi)
</script>

<style scoped></style>