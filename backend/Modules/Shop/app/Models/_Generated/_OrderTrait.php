<?php
/*
|--------------------------------------------------------------------------
|  ⚠️ 提示 ⚠️
|--------------------------------------------------------------------------
| 此文件由laravel-modeler自动生成，请勿直接手动修改。
| 如需调整，请在laravel-modeler修改/设计后重新生成。
| 如需自定义逻辑，请在Modules\Shop\Models\Order中编写。
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
use Modules\User\Models\User;
use Modules\Shop\Models\Suborder;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Shop\Database\Factories\OrderFactory;
use App\Enums\OrderStatus;

trait _OrderTrait
{
    use HasFactory;
    use SoftDeletes;

    public function getTable()
    {
        return 'orders';
    }

    protected static function newFactory()
    {
        return OrderFactory::new();
    }

    protected function casts(): array
    {
        return [
            'user_id' => 'integer',
            'order_no' => 'string',
            'total_amount' => 'float',
            'status' => OrderStatus::class,
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    
    public function suborders(): HasMany
    {
        return $this->hasMany(Suborder::class, 'order_id');
    }
    
}
