<?php
/*
|--------------------------------------------------------------------------
|  ⚠️ 提示 ⚠️
|--------------------------------------------------------------------------
| 此文件由laravel-modeler自动生成，请勿直接手动修改。
| 如需调整，请在laravel-modeler修改/设计后重新生成。
| 如需自定义逻辑，请在Modules\Shop\Models\Product中编写。
|--------------------------------------------------------------------------
*/
namespace Modules\Shop\Models\_Generated;
use Light2000\Modeler\Support\SetsCast;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Modules\Shop\Models\Category;
use Modules\Shop\Models\Athlete;
use Modules\Shop\Models\Actor;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Shop\Database\Factories\ProductFactory;
use Modules\Shop\Enums\ProductStatus;
use Modules\Shop\Enums\ProductLabel;

trait _ProductTrait
{
    use HasFactory;
    use SoftDeletes;

    public function getTable()
    {
        return 'products';
    }

    protected static function newFactory()
    {
        return ProductFactory::new();
    }

    protected function casts(): array
    {
        return [
            'name' => 'string',
            'description' => 'string',
            'price' => 'float',
            'stock' => 'integer',
            'category_id' => 'integer',
            'status' => ProductStatus::class,
            'photos' => 'array',
            'label' => SetsCast::of(ProductLabel::class),
            'cover_image' => 'string',
            'free_shipping' => 'boolean',
            'detailed_information' => 'string',
            'on_sale_time' => 'datetime',
            'production_date' => 'date',
            'spokesperson_id' => 'integer',
            'spokesperson_type' => 'string',
        ];
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'category_id');
    }
    
    public function spokesperson(): MorphTo
    {
        return $this->morphTo(__FUNCTION__);
    }
    
}
