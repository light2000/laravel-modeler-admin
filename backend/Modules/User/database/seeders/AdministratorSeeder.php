<?php

namespace Modules\User\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\User\Models\Permission;
use Modules\User\Models\Role;
use Modules\User\Models\Administrator;
use Illuminate\Support\Facades\Artisan;
class AdministratorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Artisan::call("app:meta-export");
        $permissions = Permission::all();
        $role = Role::create(['guard_name' => 'administrator', 'name' => '超级管理员']);
        $role->givePermissionTo($permissions);
        $manager = (new Administrator())->newQuery()->create(array_merge(Administrator::factory()->raw(), ['account' => 'supper.administrator', 'password' => '123']));
        $manager->assignRole($role);
    }
}
