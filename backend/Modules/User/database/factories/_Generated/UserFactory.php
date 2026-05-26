<?php
/*
|--------------------------------------------------------------------------
|  ⚠️ 提示 ⚠️
|--------------------------------------------------------------------------
| 此文件由laravel-modeler自动生成，请勿直接手动修改。
| 如需调整，请在laravel-modeler修改/设计后重新生成。
| 如需自定义逻辑，请在Modules\User\Database\Factories\UserFactory中编写。
|--------------------------------------------------------------------------
*/
namespace Modules\User\Database\Factories\_Generated;

use Illuminate\Database\Eloquent\Factories\Factory;

class UserFactory extends Factory
{

    protected $model = \Modules\User\Models\User::class;

    public function definition(): array
    {
        return [
            'password' => bcrypt('password'),
            'nickname' => fake()->name(),
            'email' => fake()->safeEmail(),
            'phone' => (string)fake()->numberBetween(13000000000, 19999999999),
            'avatar' => 'demos/avatars/' . rand(1, 10) . '.png',
            'status' => fake()->randomElement(['active', 'disabled']),
            'last_login_at' => fake()->dateTimeBetween('-2 years', 'now')->format('Y-m-d H:i:s'),
        ];
    }
}
