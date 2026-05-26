<?php
/*
|--------------------------------------------------------------------------
|  ⚠️ 提示 ⚠️
|--------------------------------------------------------------------------
| 此文件由laravel-modeler自动生成，请勿直接手动修改。
| 如需调整，请在laravel-modeler修改/设计后重新生成。
| 如需自定义逻辑，请在config/modeler.php中编写。
|--------------------------------------------------------------------------
*/
use Modules\User\Models\User;
use Modules\User\Models\Administrator;
use Modules\User\Models\Permission;
use Modules\User\Models\Token;
use Modules\User\Models\Role;
use Modules\Shop\Models\Category;
use Modules\Shop\Models\Product;
use Modules\Shop\Models\Actor;
use Modules\Shop\Models\Athlete;
use Modules\User\Database\Seeders\_Generated\UserBaseSeeder;
use Modules\User\Database\Seeders\_Generated\UserRelationSeeder;
use Modules\User\Database\Seeders\_Generated\AdministratorBaseSeeder;
use Modules\User\Database\Seeders\_Generated\AdministratorRelationSeeder;
use Modules\Shop\Database\Seeders\_Generated\CategoryBaseSeeder;
use Modules\Shop\Database\Seeders\_Generated\CategoryRelationSeeder;
use Modules\Shop\Database\Seeders\_Generated\ProductBaseSeeder;
use Modules\Shop\Database\Seeders\_Generated\ProductRelationSeeder;
use Modules\Shop\Database\Seeders\_Generated\ActorBaseSeeder;
use Modules\Shop\Database\Seeders\_Generated\AthleteBaseSeeder;

return [
    'morph_map' => [
        'user' => User::class,
        'administrator' => Administrator::class,
        'permission' => Permission::class,
        'token' => Token::class,
        'role' => Role::class,
        'category' => Category::class,
        'product' => Product::class,
        'actor' => Actor::class,
        'athlete' => Athlete::class,
    ],
    'seeders' => [
        UserBaseSeeder::class,
        AdministratorBaseSeeder::class,
        CategoryBaseSeeder::class,
        ProductBaseSeeder::class,
        ActorBaseSeeder::class,
        AthleteBaseSeeder::class,
        UserRelationSeeder::class,
        AdministratorRelationSeeder::class,
        CategoryRelationSeeder::class,
        ProductRelationSeeder::class,
    ],
    'migration_dirs' => [
        'database/migrations',
        'Modules/User/database/migrations',
        'Modules/Shop/database/migrations',
    ]
];
