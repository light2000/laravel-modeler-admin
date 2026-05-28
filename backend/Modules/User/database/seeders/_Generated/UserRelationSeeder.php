<?php
/*
|--------------------------------------------------------------------------
|  ⚠️ 提示 ⚠️
|--------------------------------------------------------------------------
| 此文件由laravel-modeler自动生成，请勿直接手动修改。
| 如需调整，请在laravel-modeler修改/设计后重新生成。
|--------------------------------------------------------------------------
*/
namespace Modules\User\Database\Seeders\_Generated;

use Modules\User\Models\User;
use Illuminate\Database\Seeder;
use Modules\User\Models\Token;
use Modules\User\Models\Role;
use App\Models\PivotRole;
use Modules\User\Models\Permission;
use App\Models\PivotPermission;
use Modules\Shop\Models\Order;
use Illuminate\Support\Facades\Log;

class UserRelationSeeder extends Seeder
{
    public function run(): void
    {
        $userList = User::orderBy('id')->get();
        $totalCount = count($userList);
        $roleListIds = Role::pluck('id');
        $groupIds = collect([]);
        $groupBaseIds = collect([]);
        while ($groupIds->count() < $userList->count()) {
            if ($groupBaseIds->isEmpty()) {
                $groupBaseIds = $roleListIds->shuffle()->chunk(3)->map(function ($group) {
                    return $group->mapWithKeys(fn ($id) => [$id => PivotRole::factory()->make()->toArray()])->all();
                });
            }
            $groupIds->push($groupBaseIds->shift());
        }
        $userList->each(function ($user) use ($groupIds) {
            $user->role()->sync(
                $groupIds->shift()
            );
        });
        $permissionListIds = Permission::pluck('id');
        $groupIds = collect([]);
        $groupBaseIds = collect([]);
        while ($groupIds->count() < $userList->count()) {
            if ($groupBaseIds->isEmpty()) {
                $groupBaseIds = $permissionListIds->shuffle()->chunk(3)->map(function ($group) {
                    return $group->mapWithKeys(fn ($id) => [$id => PivotPermission::factory()->make()->toArray()])->all();
                });
            }
            $groupIds->push($groupBaseIds->shift());
        }
        $userList->each(function ($user) use ($groupIds) {
            $user->permission()->sync(
                $groupIds->shift()
            );
        });
    }
}
