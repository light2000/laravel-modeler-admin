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

use Modules\Shop\Models\Order;
use Illuminate\Database\Seeder;
use Modules\User\Models\User;
use Modules\Shop\Models\Suborder;
use Illuminate\Support\Facades\Log;

class OrderRelationSeeder extends Seeder
{
    public function run(): void
    {
        $orderList = Order::orderBy('id')->get();
        $totalCount = count($orderList);
        $userListIds = collect(User::pluck('id'))->shuffle()->toArray();
        $userCount = count($userListIds);
        $orderList->each(function ($order, $index) use ($userListIds, $userCount) {
            try {
                $order->update([
                    'user_id' => $userListIds[$index%$userCount],
                ]);
            } catch (\Exception $e) {
                Log::info("update order user_id failed: " . $e->getMessage());
            }
        });
    }
}
