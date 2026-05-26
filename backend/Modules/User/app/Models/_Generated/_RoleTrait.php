<?php
/*
|--------------------------------------------------------------------------
|  ⚠️ 提示 ⚠️
|--------------------------------------------------------------------------
| 此文件由laravel-modeler自动生成，请勿直接手动修改。
| 如需调整，请在laravel-modeler修改/设计后重新生成。
| 如需自定义逻辑，请在Modules\User\Models\Role中编写。
|--------------------------------------------------------------------------
*/
namespace Modules\User\Models\_Generated;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Modules\User\Models\Administrator;
use Modules\User\Models\User;
use App\Models\PivotRole;
use Modules\User\Models\Permission;
use App\Models\RolePermission;

use Illuminate\Database\Eloquent\SoftDeletes;

trait _RoleTrait
{
    use SoftDeletes;

    public function getTable()
    {
        return 'roles';
    }


    protected function casts(): array
    {
        return [
            'name' => 'string',
            'guard_name' => 'string',
        ];
    }

    public function administrators(): MorphToMany
    {
        return $this->morphedByMany(Administrator::class, 'model', 'pivot_roles', 'role_id', 'model_id')
        ;
    }
        
    public function users(): MorphToMany
    {
        return $this->morphedByMany(User::class, 'model', 'pivot_roles', 'role_id', 'model_id')
        ;
    }
        
    public function permissions(): BelongsToMany
    {
        return $this->belongsToMany(Permission::class, 'role_permissions', 'role_id', 'permission_id')
        ;
    }
    
}
