<?php
/*
|--------------------------------------------------------------------------
|  ⚠️ 提示 ⚠️
|--------------------------------------------------------------------------
| 此文件由laravel-modeler自动生成，请勿直接手动修改。
| 如需调整，请在laravel-modeler修改/设计后重新生成。
|--------------------------------------------------------------------------
*/
namespace Modules\User\Database\Seeders\_Generated;

use Modules\User\Models\Administrator;
use Illuminate\Database\Seeder;

class AdministratorBaseSeeder extends Seeder
{
    public function run(): void
    {
        $num = config('modeler.fake_quantity');
        Administrator::unguard();
        Administrator::factory()
            ->count($num)
            ->sequence(fn ($sequence) => [
                'account' => fake()->lexify(str_repeat('?', rand(5, 10))) . '_' . $sequence->index,
            ])
            ->create();
    }
}
