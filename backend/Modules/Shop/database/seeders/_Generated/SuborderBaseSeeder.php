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

class SuborderBaseSeeder extends Seeder
{
    public function run(): void
    {
        $num = config('modeler.fake_quantity');
        Suborder::unguard();
        Suborder::factory()
            ->count($num)
            ->sequence(fn ($sequence) => [
                'order_id' => $sequence->index,
                'product_id' => $sequence->index,
            ])
            ->create();
    }
}
