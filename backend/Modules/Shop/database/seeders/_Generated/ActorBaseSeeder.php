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

use Modules\Shop\Models\Actor;
use Illuminate\Database\Seeder;

class ActorBaseSeeder extends Seeder
{
    public function run(): void
    {
        $num = config('modeler.fake_quantity');
        Actor::unguard();
        Actor::factory()
            ->count($num)
            ->create();
    }
}
