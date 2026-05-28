<?php
/*
|--------------------------------------------------------------------------
|  ⚠️ 提示 ⚠️
|--------------------------------------------------------------------------
| 此文件由laravel-modeler自动生成，请勿直接手动修改。
| 如需调整，请在laravel-modeler修改/设计后重新生成。
| 如需自定义逻辑，请在Modules\Shop\Database\Factories\OrderFactory中编写。
|--------------------------------------------------------------------------
*/
namespace Modules\Shop\Database\Factories\_Generated;

use Illuminate\Database\Eloquent\Factories\Factory;

class OrderFactory extends Factory
{

    protected $model = \Modules\Shop\Models\Order::class;

    public function definition(): array
    {
        return [
            'total_amount' => sprintf('%.2f', fake()->numberBetween(100, 100000000) / 100),
            'status' => fake()->randomElement(['pending', 'paid', 'shipped', 'completed', 'cancelled']),
        ];
    }
}
