<?php
/*
|--------------------------------------------------------------------------
|  ⚠️ 提示 ⚠️
|--------------------------------------------------------------------------
| 此文件由laravel-modeler自动生成，请勿直接手动修改。
| 如需调整，请在laravel-modeler修改/设计后重新生成。
| 如需自定义逻辑，请在Modules\User\Models\Token中编写。
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

use Illuminate\Database\Eloquent\SoftDeletes;

trait _TokenTrait
{
    use SoftDeletes;

    public function getTable()
    {
        return 'tokens';
    }


    protected function casts(): array
    {
        return [
            'token' => 'string',
            'expires_at' => 'datetime',
            'last_used_at' => 'datetime',
            'name' => 'string',
            'abilities' => 'string',
            'tokenable_id' => 'integer',
            'tokenable_type' => 'string',
        ];
    }

    public function tokenable(): MorphTo
    {
        return $this->morphTo(__FUNCTION__);
    }
    
}
