<?php

namespace Modules\Shop\Transformers\Product;

use App\Http\Resources\BaseResource;
use Illuminate\Http\Request;

class IndexItemResource extends BaseResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            /**
             * 产品名称
             * @var string
             */
            'name' => $this->name,
            /**
             * 价格
             * @var float
             */
            'price' => $this->price,
            /**
             * 库存
             * @var int
             */
            'stock' => $this->stock,
            /**
             * 分类
             */
            'category_id' => $this->category ? ['name' => $this->category->name] : null,
            /**
             * 产品状态
             * @var string
             */
            'status' => $this->status?->value ?? $this->status,
            /**
             * 封面图
             * @var string|null
             */
            'cover_image' => $this->cover_image,
            /**
             * 包邮
             * @var bool
             */
            'free_shipping' => $this->free_shipping,
        ];
    }
}
