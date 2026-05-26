<?php
/*
|--------------------------------------------------------------------------
|  ⚠️ 提示 ⚠️
|--------------------------------------------------------------------------
| 此文件由laravel-modeler自动生成，请勿直接手动修改。
| 如需调整，请在laravel-modeler修改/设计后重新生成。
| 如需自定义逻辑，请在Modules\Shop\Models\Actor中编写。
|--------------------------------------------------------------------------
*/
namespace Modules\Shop\Models\_Generated;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Modules\Shop\Models\Product;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Shop\Database\Factories\ActorFactory;
use App\Enums\Gender;

trait _ActorTrait
{
    use HasFactory;
    use SoftDeletes;

    public function getTable()
    {
        return 'actors';
    }

    protected static function newFactory()
    {
        return ActorFactory::new();
    }

    protected function casts(): array
    {
        return [
            'name' => 'string',
            'gender' => Gender::class,
            'birth_date' => 'date',
            'nationality' => 'string',
            'avatar' => 'string',
            'biography' => 'string',
        ];
    }

    public function product(): MorphMany
    {
        return $this->morphMany(Product::class, 'spokesperson');
    }
    
}
