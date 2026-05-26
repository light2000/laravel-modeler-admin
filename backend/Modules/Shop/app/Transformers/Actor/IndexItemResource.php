<?php

namespace Modules\Shop\Transformers\Actor;

use App\Http\Resources\BaseResource;
use Illuminate\Http\Request;

class IndexItemResource extends BaseResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            /**
             * 演员名称
             * @var string
             */
            'name' => $this->name,
            /**
             * 性别
             * @var string|null
             */
            'gender' => $this->gender?->value ?? $this->gender,
            /**
             * 国籍
             * @var string|null
             */
            'nationality' => $this->nationality,
            /**
             * 头像
             * @var string|null
             */
            'avatar' => $this->avatar,
        ];
    }
}
