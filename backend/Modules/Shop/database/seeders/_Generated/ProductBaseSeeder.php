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

use Modules\Shop\Models\Product;
use Illuminate\Database\Seeder;

class ProductBaseSeeder extends Seeder
{
    public function run(): void
    {
        $num = config('modeler.fake_quantity');
        Product::unguard();
        Product::factory()
            ->count($num)
            ->sequence(fn ($sequence) => [
                'category_id' => $sequence->index,
                'spokesperson_id' => null,
                'spokesperson_type' => null,
            ])
            ->create();
    }
}
