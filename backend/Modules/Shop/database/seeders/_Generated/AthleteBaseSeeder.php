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

use Modules\Shop\Models\Athlete;
use Illuminate\Database\Seeder;

class AthleteBaseSeeder extends Seeder
{
    public function run(): void
    {
        $num = config('modeler.fake_quantity');
        Athlete::unguard();
        Athlete::factory()
            ->count($num)
            ->create();
    }
}
