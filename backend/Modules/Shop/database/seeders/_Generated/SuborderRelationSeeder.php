<?php
/*
|--------------------------------------------------------------------------
|  ⚠️ 提示 ⚠️
|--------------------------------------------------------------------------
| 此文件由laravel-modeler自动生成，请勿直接手动修改。
| 如需调整，请在laravel-modeler修改/设计后重新生成。
|--------------------------------------------------------------------------
*/
namespace Modules\Shop\Database\Seeders\_Generated;

use Modules\Shop\Models\Suborder;
use Illuminate\Database\Seeder;
use Modules\Shop\Models\Order;
use Modules\Shop\Models\Product;
use Illuminate\Support\Facades\Log;

class SuborderRelationSeeder extends Seeder
{
    public function run(): void
    {
        $suborderList = Suborder::orderBy('id')->get();
        $totalCount = count($suborderList);
        $orderListIds = collect(Order::pluck('id'))->shuffle()->toArray();
        $orderCount = count($orderListIds);
        $suborderList->each(function ($suborder, $index) use ($orderListIds, $orderCount) {
            try {
                $suborder->update([
                    'order_id' => $orderListIds[$index%$orderCount],
                ]);
            } catch (\Exception $e) {
                Log::info("update suborder order_id failed: " . $e->getMessage());
            }
        });
        $productListIds = collect(Product::pluck('id'))->shuffle()->toArray();
        $productCount = count($productListIds);
        $suborderList->each(function ($suborder, $index) use ($productListIds, $productCount) {
            try {
                $suborder->update([
                    'product_id' => $productListIds[$index%$productCount],
                ]);
            } catch (\Exception $e) {
                Log::info("update suborder product_id failed: " . $e->getMessage());
            }
        });
    }
}
