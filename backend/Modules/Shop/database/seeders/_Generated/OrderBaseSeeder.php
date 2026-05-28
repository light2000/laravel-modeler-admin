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

class OrderBaseSeeder extends Seeder
{
    public function run(): void
    {
        $num = config('modeler.fake_quantity');
        Order::unguard();
        Order::factory()
            ->count($num)
            ->sequence(fn ($sequence) => [
                'user_id' => $sequence->index,
                'order_no' => fake()->lexify(str_repeat('?', rand(5, 10))) . '_' . $sequence->index,
            ])
            ->create();
    }
}
