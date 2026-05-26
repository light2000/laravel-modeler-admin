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

use Modules\User\Models\Administrator;
use Illuminate\Database\Seeder;
use Modules\User\Models\Token;
use Modules\User\Models\Role;
use App\Models\PivotRole;
use Illuminate\Support\Facades\Log;

class AdministratorRelationSeeder extends Seeder
{
    public function run(): void
    {
        $administratorList = Administrator::orderBy('id')->get();
        $totalCount = count($administratorList);
        $roleListIds = Role::pluck('id');
        $groupIds = collect([]);
        $groupBaseIds = collect([]);
        while ($groupIds->count() < $administratorList->count()) {
            if ($groupBaseIds->isEmpty()) {
                $groupBaseIds = $roleListIds->shuffle()->chunk(3)->map(function ($group) {
                    return $group->mapWithKeys(fn ($id) => [$id => PivotRole::factory()->make()->toArray()])->all();
                });
            }
            $groupIds->push($groupBaseIds->shift());
        }
        $administratorList->each(function ($administrator) use ($groupIds) {
            $administrator->role()->sync(
                $groupIds->shift()
            );
        });
    }
}
