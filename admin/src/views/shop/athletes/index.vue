<template>
  <div class="table-box">
    <SearchForm v-model:query="list.query" :schema="athleteSearchSchema" :reload="list.reload" />
    <ProTable
      v-model:query="list.query"
      :columns="athleteTableSchema"
      selectable
      :loading="list.loading"
      :rows="list.rows"
      :total="list.total"
      :reload="list.reload"
    >
      <template #toolbar="scope">
        <el-button v-can="'shop.athlete.store'" type="primary" :icon="CirclePlus" @click="form.openCreate()">
          新增运动员
        </el-button>
        <el-button v-can="'shop.athlete.destroy'" type="danger" :icon="Delete" plain :disabled="!scope.isSelected">
          批量删除
        </el-button>
      </template>
      <template #operation="{ row }">
        <el-button v-can="'shop.athlete.update'" type="primary" link :icon="EditPen" @click="form.openUpdate(row.id)">编辑</el-button>
        <el-button v-can="'shop.athlete.destroy'" link type="danger" :icon="Delete" @click="del.execute(row.id)">删除</el-button>
        <el-button v-can="'shop.athlete.show'" link type="primary" :icon="View" @click="detail.open(row.id)">详情</el-button>
      </template>
    </ProTable>
    <PopupForm
      v-model:visible="form.visible"
      :mode="form.mode"
      :schema="athleteFormSchema"
      :record="form.record"
      :title="form.title"
      :errors="form.errors"
      @submit="form.submit"
    />
    <PopupDetail
      v-model:visible="detail.visible"
      type="dialog"
      :title="detail.title"
      :schema="athleteDetailSchema"
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
import { athleteApi } from '@/api/modules/shop/athlete.api'
import { athleteSearchSchema, athleteTableSchema, athleteFormSchema, athleteDetailSchema } from './schemas'
import { useCrud } from '@/composables/crud/useCrud'

defineOptions({
  name: 'ShopAthleteIndex',
})

const { list, form, del, detail } = useCrud(athleteApi)
</script>

<style scoped></style>
