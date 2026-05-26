<?php
/*
|--------------------------------------------------------------------------
|  ⚠️ 提示 ⚠️
|--------------------------------------------------------------------------
| 此文件由laravel-modeler自动生成，请勿直接手动修改。
| 如需调整，请在laravel-modeler修改/设计后重新生成。
| 如需自定义逻辑，请在Modules\Shop\Database\Factories\AthleteFactory中编写。
|--------------------------------------------------------------------------
*/
namespace Modules\Shop\Database\Factories\_Generated;

use Illuminate\Database\Eloquent\Factories\Factory;

class AthleteFactory extends Factory
{

    protected $model = \Modules\Shop\Models\Athlete::class;

    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'gender' => fake()->randomElement(['male', 'female']),
            'height' => sprintf('%.3f', fake()->numberBetween(500, 2500) / 1000),
            'weight' => sprintf('%.3f', fake()->numberBetween(20000, 200000) / 1000),
            'birthday' => fake()->date('Y-m-d'),
            'avatar' => 'demos/avatars/' . rand(1, 10) . '.png',
        ];
    }
}
