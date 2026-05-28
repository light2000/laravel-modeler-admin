<template>
    <div v-loading="loading" class="dashboard">
        <section class="dashboard-hero card">
            <div class="hero-inner">
                <div>
                    <h1 class="hero-title">{{ greeting }}，{{ displayName }}</h1>
                    <p class="hero-subtitle">
                        欢迎使用 {{ appName }}。以下为系统数据概览，涵盖用户、权限与商城业务模块。
                    </p>
                </div>
                <div class="hero-meta">
                    <span class="meta-chip">{{ todayText }}</span>
                    <span class="meta-chip">数据实时统计</span>
                </div>
            </div>
        </section>

        <section class="stat-grid">
            <article
                v-for="card in statCards"
                :key="card.key"
                class="stat-card card"
                :class="`stat-card--${card.tone}`"
                @click="go(card.path)"
            >
                <div class="stat-icon">
                    <Icon :name="card.icon" :size="24" />
                </div>
                <div class="stat-body">
                    <p class="stat-label">{{ card.label }}</p>
                    <p class="stat-value">{{ formatNumber(overview[card.key]) }}</p>
                    <p class="stat-hint">{{ card.hint }}</p>
                </div>
            </article>
        </section>

        <section class="dashboard-main">
            <div class="panel card">
                <div class="panel-header">
                    <div>
                        <h3>近 7 日新增趋势</h3>
                        <span class="panel-sub">用户与产品每日新增量</span>
                    </div>
                </div>
                <div v-if="trends.labels.length" class="trend-chart">
                    <div v-for="(label, index) in trends.labels" :key="label" class="trend-group">
                        <div class="bars">
                            <div
                                class="bar bar--users"
                                :style="{ height: barHeight(trends.users[index], maxTrend) }"
                                :title="`用户 +${trends.users[index]}`"
                            />
                            <div
                                class="bar bar--products"
                                :style="{ height: barHeight(trends.products[index], maxTrend) }"
                                :title="`产品 +${trends.products[index]}`"
                            />
                        </div>
                        <span class="trend-label">{{ label }}</span>
                    </div>
                </div>
                <el-empty v-else description="暂无趋势数据" :image-size="72" />
                <div class="chart-legend">
                    <span class="legend-item"><i class="dot dot--users" />新增用户</span>
                    <span class="legend-item"><i class="dot dot--products" />新增产品</span>
                </div>
            </div>

            <div class="panel card">
                <div class="panel-header">
                    <h3>状态分布</h3>
                </div>
                <div class="distribution-list">
                    <div class="distribution-block">
                        <div class="panel-sub" style="margin-bottom: 10px">用户状态</div>
                        <div v-for="item in userStatus" :key="item.status" class="distribution-item">
                            <div class="dist-head">
                                <span class="dist-name">{{ item.label }}</span>
                                <span class="dist-count">{{ item.count }}</span>
                            </div>
                            <el-progress
                                :percentage="percent(item.count, overview.users)"
                                :stroke-width="8"
                                :color="item.status === 'active' ? '#4f46e5' : '#94a3b8'"
                                :show-text="false"
                            />
                        </div>
                    </div>
                    <div class="distribution-block">
                        <div class="panel-sub" style="margin-bottom: 10px">产品状态</div>
                        <div v-for="item in productStatus" :key="item.status" class="distribution-item">
                            <div class="dist-head">
                                <span class="dist-name">{{ item.label }}</span>
                                <span class="dist-count">{{ item.count }}</span>
                            </div>
                            <el-progress
                                :percentage="percent(item.count, overview.products)"
                                :stroke-width="8"
                                :color="item.status === 'on_sale' ? '#059669' : '#f59e0b'"
                                :show-text="false"
                            />
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="dashboard-bottom">
            <div class="panel card">
                <div class="panel-header">
                    <h3>最新用户</h3>
                    <el-button link type="primary" @click="go('/user/users')">查看全部</el-button>
                </div>
                <el-table :data="recentUsers" size="small" stripe>
                    <el-table-column label="用户" min-width="160">
                        <template #default="{ row }">
                            <div class="user-cell">
                                <el-avatar :size="36" :src="row.avatar || undefined">
                                    {{ (row.nickname || row.username || '?').slice(0, 1) }}
                                </el-avatar>
                                <div class="user-meta">
                                    <div class="user-name">{{ row.nickname || row.username }}</div>
                                    <div class="user-sub">@{{ row.username }}</div>
                                </div>
                            </div>
                        </template>
                    </el-table-column>
                    <el-table-column label="状态" width="88" align="center">
                        <template #default="{ row }">
                            <el-tag :type="row.status === 'active' ? 'success' : 'info'" size="small">
                                {{ statusLabel('user_status', row.status) }}
                            </el-tag>
                        </template>
                    </el-table-column>
                    <el-table-column label="注册时间" width="110" align="right">
                        <template #default="{ row }">
                            {{ formatDate(row.created_at) }}
                        </template>
                    </el-table-column>
                </el-table>
            </div>

            <div class="panel card">
                <div class="panel-header">
                    <h3>最新产品</h3>
                    <el-button link type="primary" @click="go('/shop/products')">查看全部</el-button>
                </div>
                <el-table :data="recentProducts" size="small" stripe>
                    <el-table-column label="产品" min-width="180">
                        <template #default="{ row }">
                            <div class="product-cell">
                                <img v-if="row.cover_image" :src="row.cover_image" class="product-thumb" alt="" />
                                <div v-else class="product-thumb product-thumb--placeholder">
                                    <Icon name="ep:Picture" :size="18" />
                                </div>
                                <div>
                                    <div class="product-name">{{ row.name }}</div>
                                    <div class="product-sub">{{ row.category_name || '未分类' }}</div>
                                </div>
                            </div>
                        </template>
                    </el-table-column>
                    <el-table-column label="价格" width="88" align="right">
                        <template #default="{ row }">¥{{ formatPrice(row.price) }}</template>
                    </el-table-column>
                    <el-table-column label="状态" width="72" align="center">
                        <template #default="{ row }">
                            <el-tag :type="row.status === 'on_sale' ? 'success' : 'warning'" size="small">
                                {{ statusLabel('product_status', row.status) }}
                            </el-tag>
                        </template>
                    </el-table-column>
                </el-table>
            </div>

            <div class="panel card">
                <div class="panel-header">
                    <h3>库存预警</h3>
                    <span class="panel-sub">库存 ≤ 10</span>
                </div>
                <el-table :data="lowStockProducts" size="small" stripe empty-text="暂无低库存产品">
                    <el-table-column prop="name" label="产品" min-width="140" show-overflow-tooltip />
                    <el-table-column label="库存" width="72" align="center">
                        <template #default="{ row }">
                            <span :class="row.stock <= 5 ? 'stock-warn' : 'stock-ok'">{{ row.stock }}</span>
                        </template>
                    </el-table-column>
                    <el-table-column label="状态" width="72" align="center">
                        <template #default="{ row }">
                            <el-tag :type="row.status === 'on_sale' ? 'success' : 'info'" size="small">
                                {{ statusLabel('product_status', row.status) }}
                            </el-tag>
                        </template>
                    </el-table-column>
                </el-table>
            </div>
        </section>
    </div>
</template>

<script setup lang="ts">
import { computed, onMounted, reactive, ref } from 'vue'
import { useRouter } from 'vue-router'
import Icon from '@/components/Icon/index.vue'
import { useAuthStore } from '@/store/modules/auth'
import { getOptionLabel, getOptions } from '@/meta/enums.utils'
import {
    fetchDashboard,
    type DashboardOverview,
    type LowStockProduct,
    type RecentProduct,
    type RecentUser,
    type StatusSlice
} from '@/api/modules/dashboard.api'

defineOptions({
    name: 'Dashboard'
})

const router = useRouter()
const authStore = useAuthStore()
const loading = ref(false)
const appName = import.meta.env.VITE_APP_NAME

const overview = reactive<DashboardOverview>({
    users: 0,
    administrators: 0,
    roles: 0,
    categories: 0,
    products: 0,
    actors: 0,
    athletes: 0
})

const userStatus = ref<StatusSlice[]>([])
const productStatus = ref<StatusSlice[]>([])
const recentUsers = ref<RecentUser[]>([])
const recentProducts = ref<RecentProduct[]>([])
const lowStockProducts = ref<LowStockProduct[]>([])
const trends = reactive({
    labels: [] as string[],
    users: [] as number[],
    products: [] as number[]
})

const statCards = [
    { key: 'users' as const, label: '前台用户', hint: 'users 表', icon: 'ep:User', tone: 'users', path: '/user/users' },
    {
        key: 'administrators' as const,
        label: '管理员',
        hint: 'administrators 表',
        icon: 'ep:UserFilled',
        tone: 'admins',
        path: '/user/administrators'
    },
    { key: 'roles' as const, label: '角色', hint: 'roles 表', icon: 'ep:Key', tone: 'roles', path: '/user/roles' },
    {
        key: 'products' as const,
        label: '产品',
        hint: '商城核心 SKU',
        icon: 'ep:Goods',
        tone: 'shop',
        path: '/shop/products'
    },
    {
        key: 'categories' as const,
        label: '分类',
        hint: 'categories 表',
        icon: 'ep:Menu',
        tone: 'shop',
        path: '/shop/categories'
    },
    { key: 'actors' as const, label: '演员', hint: 'actors 表', icon: 'ep:Star', tone: 'shop', path: '/shop/actors' },
    {
        key: 'athletes' as const,
        label: '运动员',
        hint: 'athletes 表',
        icon: 'ep:Trophy',
        tone: 'shop',
        path: '/shop/athletes'
    }
]

const displayName = computed(() => authStore.administrator?.nickname || authStore.administrator?.account || '管理员')

const greeting = computed(() => {
    const hour = new Date().getHours()
    if (hour < 6) return '夜深了'
    if (hour < 12) return '早上好'
    if (hour < 14) return '中午好'
    if (hour < 18) return '下午好'
    return '晚上好'
})

const todayText = computed(() => {
    const now = new Date()
    const weekdays = ['日', '一', '二', '三', '四', '五', '六']
    return `${now.getFullYear()}年${now.getMonth() + 1}月${now.getDate()}日 星期${weekdays[now.getDay()]}`
})

const maxTrend = computed(() => {
    const values = [...trends.users, ...trends.products]
    return Math.max(...values, 1)
})

function formatNumber(value: number) {
    return new Intl.NumberFormat('zh-CN').format(value ?? 0)
}

function formatPrice(value: number) {
    return Number(value ?? 0).toFixed(2)
}

function formatDate(iso: string | null) {
    if (!iso) return '-'
    const date = new Date(iso)
    return `${date.getMonth() + 1}/${date.getDate()}`
}

function percent(part: number, total: number) {
    if (!total) return 0
    return Math.round((part / total) * 100)
}

function barHeight(value: number, max: number) {
    const ratio = max > 0 ? value / max : 0
    return `${Math.max(ratio * 100, value > 0 ? 8 : 2)}%`
}

function statusLabel(enumKey: 'user_status' | 'product_status', value: string) {
    return getOptionLabel(getOptions(enumKey), value) || value
}

function go(path: string) {
    router.push(path)
}

async function loadDashboard() {
    loading.value = true
    try {
        const data = await fetchDashboard()
        Object.assign(overview, data.overview)
        userStatus.value = data.user_status
        productStatus.value = data.product_status
        recentUsers.value = data.recent_users
        recentProducts.value = data.recent_products
        lowStockProducts.value = data.low_stock_products
        trends.labels = data.trends.labels
        trends.users = data.trends.users
        trends.products = data.trends.products
    } finally {
        loading.value = false
    }
}

onMounted(loadDashboard)
</script>

<style scoped lang="scss">
@use './index';
</style>
