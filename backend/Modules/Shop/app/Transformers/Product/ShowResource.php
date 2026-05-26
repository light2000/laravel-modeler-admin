<?php

namespace Modules\Shop\Transformers\Product;

use App\Http\Resources\BaseResource;
use Illuminate\Http\Request;

class ShowResource extends BaseResource
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
             * 产品描述
             * @var string|null
             */
            'description' => $this->description,
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
             * 组图
             * @var array|null
             */
            'photos' => $this->photos,
            /**
             * 标签
             * @var array|null
             */
            'label' => $this->label,
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
            /**
             * 详细信息
             * @var string|null
             */
            'detailed_information' => $this->detailed_information,
            /**
             * 上架时间
             * @var string|null
             */
            'on_sale_time' => $this->on_sale_time,
            /**
             * 生产日期
             * @var string|null
             */
            'production_date' => $this->production_date,
            /**
             * 代言人
             * @var int|null
             */
            'spokesperson_id' => $this->spokesperson_id,
            /**
             * 代言人类型
             * @var string|null
             */
            'spokesperson_type' => $this->spokesperson_type,
        ];
    }
}
