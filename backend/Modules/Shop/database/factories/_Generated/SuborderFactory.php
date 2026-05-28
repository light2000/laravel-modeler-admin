<?php
/*
|--------------------------------------------------------------------------
|  ⚠️ 提示 ⚠️
|--------------------------------------------------------------------------
| 此文件由laravel-modeler自动生成，请勿直接手动修改。
| 如需调整，请在laravel-modeler修改/设计后重新生成。
| 如需自定义逻辑，请在Modules\Shop\Database\Factories\SuborderFactory中编写。
|--------------------------------------------------------------------------
*/
namespace Modules\Shop\Database\Factories\_Generated;

use Illuminate\Database\Eloquent\Factories\Factory;

class SuborderFactory extends Factory
{

    protected $model = \Modules\Shop\Models\Suborder::class;

    public function definition(): array
    {
        return [
            'quantity' => fake()->numberBetween(1, 999),
            'price' => sprintf('%.2f', fake()->numberBetween(1, 9999999) / 100),
            'subtotal' => sprintf('%.2f', fake()->numberBetween(1, 99999999) / 100),
            'status' => fake()->randomElement(['pending', 'paid', 'shipped', 'completed', 'cancelled']),
            'remark' => fake()->lexify(str_repeat('?', rand(5, 10))),
        ];
    }
}
