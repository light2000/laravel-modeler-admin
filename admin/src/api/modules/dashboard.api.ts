import http from '@/api/core/client'

export interface DashboardOverview {
    users: number
    administrators: number
    roles: number
    categories: number
    products: number
    orders: number
    actors: number
    athletes: number
}

export interface StatusSlice {
    status: string
    label: string
    count: number
}

export interface RecentUser {
    id: number
    username: string
    nickname: string | null
    avatar: string | null
    status: string
    created_at: string | null
}

export interface RecentProduct {
    id: number
    name: string
    price: number
    stock: number
    status: string
    cover_image: string | null
    category_name: string | null
    created_at: string | null
}

export interface LowStockProduct {
    id: number
    name: string
    stock: number
    status: string
}

export interface DashboardData {
    overview: DashboardOverview
    user_status: StatusSlice[]
    product_status: StatusSlice[]
    recent_users: RecentUser[]
    recent_products: RecentProduct[]
    low_stock_products: LowStockProduct[]
    trends: {
        labels: string[]
        users: number[]
        products: number[]
    }
}

export function fetchDashboard(): Promise<DashboardData> {
    return http.get<DashboardData, DashboardData>('/dashboard')
}
