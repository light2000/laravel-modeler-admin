<?php
/*
|--------------------------------------------------------------------------
|  ⚠️ 提示 ⚠️
|--------------------------------------------------------------------------
| 此文件由laravel-modeler自动生成，请勿直接手动修改。
| 如需调整，请在laravel-modeler修改/设计后重新生成。
| 如需自定义逻辑，请在Modules\Shop\Database\Factories\CategoryFactory中编写。
|--------------------------------------------------------------------------
*/
namespace Modules\Shop\Database\Factories\_Generated;

use Illuminate\Database\Eloquent\Factories\Factory;

class CategoryFactory extends Factory
{

    protected $model = \Modules\Shop\Models\Category::class;

    public function definition(): array
    {
        return [
            'sort_order' => fake()->numberBetween(0, 9999),
            'icon' => 'demos/images/' . rand(1, 10) . '.jpg',
        ];
    }
}
