<?php

namespace Modules\Shop\Transformers\Athlete;

use App\Http\Resources\BaseResource;
use Illuminate\Http\Request;

class IndexItemResource extends BaseResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            /**
             * 姓名
             * @var string
             */
            'name' => $this->name,
            /**
             * 性别
             * @var string|null
             */
            'gender' => $this->gender?->value ?? $this->gender,
            /**
             * 身高
             * @var float|null
             */
            'height' => $this->height,
            /**
             * 体重
             * @var float|null
             */
            'weight' => $this->weight,
            /**
             * 头像
             * @var string|null
             */
            'avatar' => $this->avatar,
        ];
    }
}
