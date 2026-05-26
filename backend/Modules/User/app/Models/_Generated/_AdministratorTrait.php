<?php
/*
|--------------------------------------------------------------------------
|  ⚠️ 提示 ⚠️
|--------------------------------------------------------------------------
| 此文件由laravel-modeler自动生成，请勿直接手动修改。
| 如需调整，请在laravel-modeler修改/设计后重新生成。
| 如需自定义逻辑，请在Modules\User\Models\Administrator中编写。
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
use Modules\User\Models\Token;
use Modules\User\Models\Role;
use App\Models\PivotRole;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\User\Database\Factories\AdministratorFactory;
use Modules\User\Enums\UserStatus;

trait _AdministratorTrait
{
    use HasFactory;
    use SoftDeletes;

    public function getTable()
    {
        return 'administrators';
    }

    protected static function newFactory()
    {
        return AdministratorFactory::new();
    }

    protected function casts(): array
    {
        return [
            'status' => UserStatus::class,
            'account' => 'string',
            'password' => 'string',
            'nickname' => 'string',
            'avatar' => 'string',
        ];
    }

    public function token(): MorphMany
    {
        return $this->morphMany(Token::class, 'tokenable');
    }
    
    public function role(): MorphToMany
    {
        return $this->morphToMany(Role::class, 'model', 'pivot_roles', 'model_id', 'role_id')
        ;
    }
    
}
