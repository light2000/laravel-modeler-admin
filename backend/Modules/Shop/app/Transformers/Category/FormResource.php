<?php

namespace Modules\Shop\Transformers\Category;

use App\Http\Resources\BaseResource;
use Illuminate\Http\Request;

class FormResource extends BaseResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            /**
             * 分类名称
             * @var string
             */
            'name' => $this->name,
            /**
             * 父分类
             * @var int|null
             */
            'parent_id' => $this->parent_id,
            /**
             * 排序
             * @var int
             */
            'sort_order' => $this->sort_order,
            /**
             * 图标
             * @var string|null
             */
            'icon' => $this->icon,
        ];
    }
}
