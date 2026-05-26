<?php
/*
|--------------------------------------------------------------------------
|  ⚠️ 提示 ⚠️
|--------------------------------------------------------------------------
| 此文件由laravel-modeler自动生成，请勿直接手动修改。
| 如需调整，请在laravel-modeler修改/设计后重新生成。
| 如需自定义逻辑，请在Modules\Shop\Models\Category中编写。
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
use Modules\Shop\Models\Category;
use Modules\Shop\Models\Product;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Shop\Database\Factories\CategoryFactory;

trait _CategoryTrait
{
    use HasFactory;
    use SoftDeletes;

    public function getTable()
    {
        return 'categories';
    }

    protected static function newFactory()
    {
        return CategoryFactory::new();
    }

    protected function casts(): array
    {
        return [
            'name' => 'string',
            'parent_id' => 'integer',
            'sort_order' => 'integer',
            'icon' => 'string',
        ];
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }
    
    public function children(): HasMany
    {
        return $this->hasMany(Category::class, 'parent_id');
    }
    
    public function products(): HasMany
    {
        return $this->hasMany(Product::class, 'category_id');
    }
    
}
