<?php
/*
|--------------------------------------------------------------------------
|  ⚠️ 提示 ⚠️
|--------------------------------------------------------------------------
| 此文件由laravel-modeler自动生成，请勿直接手动修改。
| 如需调整，请在laravel-modeler修改/设计后重新生成。
| 如需自定义逻辑，请在Modules\Shop\Database\Factories\ProductFactory中编写。
|--------------------------------------------------------------------------
*/
namespace Modules\Shop\Database\Factories\_Generated;

use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{

    protected $model = \Modules\Shop\Models\Product::class;

    public function definition(): array
    {
        return [
            'name' => fake()->lexify(str_repeat('?', rand(5, 10))),
            'description' => fake()->lexify(str_repeat('?', rand(30, 90))),
            'price' => sprintf('%.2f', fake()->numberBetween(1, 99999999) / 100),
            'stock' => fake()->numberBetween(0, 10000),
            'status' => fake()->randomElement(['on_sale', 'off_sale']),
            'photos' => array_map(fn () => 'demos/images/' . rand(1, 10) . '.jpg', range(2, 5)),
            'label' => array_map(fn () => fake()->randomElement(['best_seller', 'new', 'recommend', 'promotion']), range(2, 5)),
            'cover_image' => 'demos/images/' . rand(1, 10) . '.jpg',
            'free_shipping' => fake()->boolean(),
            'detailed_information' => fake()->lexify(str_repeat('?', rand(100, 120))),
            'on_sale_time' => fake()->dateTimeBetween('-2 years', 'now')->format('Y-m-d H:i:s'),
            'production_date' => fake()->date('Y-m-d'),
        ];
    }
}
