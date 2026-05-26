<?php
/*
|--------------------------------------------------------------------------
|  ⚠️ 提示 ⚠️
|--------------------------------------------------------------------------
| 此文件由laravel-modeler自动生成，请勿直接手动修改。
| 如需调整，请在laravel-modeler修改/设计后重新生成。
| 如需自定义逻辑，请在Modules\Shop\Database\Factories\ActorFactory中编写。
|--------------------------------------------------------------------------
*/
namespace Modules\Shop\Database\Factories\_Generated;

use Illuminate\Database\Eloquent\Factories\Factory;

class ActorFactory extends Factory
{

    protected $model = \Modules\Shop\Models\Actor::class;

    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'gender' => fake()->randomElement(['male', 'female']),
            'birth_date' => fake()->date('Y-m-d'),
            'nationality' => fake()->country(),
            'avatar' => 'demos/avatars/' . rand(1, 10) . '.png',
            'biography' => fake()->lexify(str_repeat('?', rand(30, 90))),
        ];
    }
}
