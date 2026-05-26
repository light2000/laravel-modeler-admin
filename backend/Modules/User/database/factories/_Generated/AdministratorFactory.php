<?php
/*
|--------------------------------------------------------------------------
|  ⚠️ 提示 ⚠️
|--------------------------------------------------------------------------
| 此文件由laravel-modeler自动生成，请勿直接手动修改。
| 如需调整，请在laravel-modeler修改/设计后重新生成。
| 如需自定义逻辑，请在Modules\User\Database\Factories\AdministratorFactory中编写。
|--------------------------------------------------------------------------
*/
namespace Modules\User\Database\Factories\_Generated;

use Illuminate\Database\Eloquent\Factories\Factory;

class AdministratorFactory extends Factory
{

    protected $model = \Modules\User\Models\Administrator::class;

    public function definition(): array
    {
        return [
            'status' => fake()->randomElement(['active', 'disabled']),
            'password' => fake()->lexify(str_repeat('?', rand(5, 10))),
            'nickname' => fake()->lexify(str_repeat('?', rand(5, 10))),
            'avatar' => 'demos/archives/' . rand(1, 10) . '.zip',
        ];
    }
}
