<?php
/*
|--------------------------------------------------------------------------
|  ⚠️ 提示 ⚠️
|--------------------------------------------------------------------------
| 此文件由laravel-modeler自动生成，请勿直接手动修改。
| 如需调整，请在laravel-modeler修改/设计后重新生成。
| 如需自定义逻辑，请在App\Models\PivotRole中编写。
|--------------------------------------------------------------------------
*/
namespace App\Models\_Generated;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;


trait _PivotRoleTrait
{

    public function getTable()
    {
        return 'pivot_roles';
    }


    protected function casts(): array
    {
        return [
            'role_id' => 'integer',
            'model_id' => 'integer',
            'model_type' => 'string',
        ];
    }

}
