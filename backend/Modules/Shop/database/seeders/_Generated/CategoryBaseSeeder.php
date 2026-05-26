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

use Modules\Shop\Models\Category;
use Illuminate\Database\Seeder;

class CategoryBaseSeeder extends Seeder
{
    public function run(): void
    {
        $num = config('modeler.fake_quantity');
        Category::unguard();
        Category::factory()
            ->count($num)
            ->sequence(fn ($sequence) => [
                'name' => fake()->lexify(str_repeat('?', rand(5, 10))) . '_' . $sequence->index,
                'parent_id' => null,
            ])
            ->create();
    }
}
