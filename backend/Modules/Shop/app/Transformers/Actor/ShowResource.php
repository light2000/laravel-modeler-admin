<?php

namespace Modules\Shop\Transformers\Actor;

use App\Http\Resources\BaseResource;
use Illuminate\Http\Request;

class ShowResource extends BaseResource
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
             * 出生日期
             * @var string|null
             */
            'birth_date' => $this->birth_date,
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
            /**
             * 简介
             * @var string|null
             */
            'biography' => $this->biography,
        ];
    }
}
