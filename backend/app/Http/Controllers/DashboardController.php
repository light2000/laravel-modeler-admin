<?php

namespace App\Http\Controllers;

use Modules\User\Enums\UserStatus;
use App\Http\Resources\DashboardResource;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Modules\Shop\Enums\ProductStatus;
use Modules\Shop\Models\Actor;
use Modules\Shop\Models\Athlete;
use Modules\Shop\Models\Category;
use Modules\Shop\Models\Product;
use Modules\User\Models\Administrator;
use Modules\User\Models\Role;
use Modules\User\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $overview = [
            'users' => User::query()->count(),
            'administrators' => Administrator::query()->count(),
            'roles' => Role::query()->count(),
            'categories' => Category::query()->count(),
            'products' => Product::query()->count(),
            'actors' => Actor::query()->count(),
            'athletes' => Athlete::query()->count(),
        ];

        $userStatus = $this->groupByStatus(User::query(), 'status', UserStatus::cases());
        $productStatus = $this->groupByStatus(Product::query(), 'status', ProductStatus::cases());

        $recentUsers = User::query()
            ->select(['id', 'username', 'nickname', 'avatar', 'status', 'created_at'])
            ->latest('id')
            ->limit(6)
            ->get()
            ->map(fn (User $user) => [
                'id' => $user->id,
                'username' => $user->username,
                'nickname' => $user->nickname,
                'avatar' => $user->avatar,
                'status' => $user->status?->value ?? $user->status,
                'created_at' => $user->created_at?->toIso8601String(),
            ]);

        $recentProducts = Product::query()
            ->with('category:id,name')
            ->select(['id', 'name', 'price', 'stock', 'status', 'cover_image', 'category_id', 'created_at'])
            ->latest('id')
            ->limit(6)
            ->get()
            ->map(fn (Product $product) => [
                'id' => $product->id,
                'name' => $product->name,
                'price' => $product->price,
                'stock' => $product->stock,
                'status' => $product->status instanceof ProductStatus ? $product->status->value : $product->status,
                'cover_image' => $product->cover_image,
                'category_name' => $product->category?->name,
                'created_at' => $product->created_at?->toIso8601String(),
            ]);

        $lowStockProducts = Product::query()
            ->select(['id', 'name', 'stock', 'status'])
            ->where('stock', '<=', 10)
            ->orderBy('stock')
            ->limit(5)
            ->get()
            ->map(fn (Product $product) => [
                'id' => $product->id,
                'name' => $product->name,
                'stock' => $product->stock,
                'status' => $product->status instanceof ProductStatus ? $product->status->value : $product->status,
            ]);

        return new DashboardResource([
            'overview' => $overview,
            'user_status' => $userStatus,
            'product_status' => $productStatus,
            'recent_users' => $recentUsers,
            'recent_products' => $recentProducts,
            'low_stock_products' => $lowStockProducts,
            'trends' => [
                'labels' => $this->lastSevenDayLabels(),
                'users' => $this->dailyCreatedCounts(User::query(), 'users'),
                'products' => $this->dailyCreatedCounts(Product::query(), 'products'),
            ],
        ]);
    }

    /**
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  array<int, UserStatus|ProductStatus>  $cases
     * @return array<int, array{status: string, label: string, count: int}>
     */
    private function groupByStatus($query, string $column, array $cases): array
    {
        $counts = (clone $query)
            ->select($column, DB::raw('count(*) as aggregate'))
            ->groupBy($column)
            ->pluck('aggregate', $column);

        return collect($cases)->map(function ($case) use ($counts) {
            $value = $case->value;

            return [
                'status' => $value,
                'label' => $case->label(),
                'count' => (int) ($counts[$value] ?? 0),
            ];
        })->values()->all();
    }

    /**
     * @return array<int, string>
     */
    private function lastSevenDayLabels(): array
    {
        return collect(range(6, 0))
            ->map(fn (int $daysAgo) => Carbon::today()->subDays($daysAgo)->format('m-d'))
            ->values()
            ->all();
    }

    /**
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return array<int, int>
     */
    private function dailyCreatedCounts($query, string $table): array
    {
        $start = Carbon::today()->subDays(6)->startOfDay();

        $rows = (clone $query)
            ->where("{$table}.created_at", '>=', $start)
            ->selectRaw('DATE(created_at) as day, COUNT(*) as aggregate')
            ->groupBy('day')
            ->pluck('aggregate', 'day');

        return collect(range(6, 0))
            ->map(function (int $daysAgo) use ($rows) {
                $day = Carbon::today()->subDays($daysAgo)->toDateString();

                return (int) ($rows[$day] ?? 0);
            })
            ->values()
            ->all();
    }
}
