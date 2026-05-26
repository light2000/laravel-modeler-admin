<?php

namespace Modules\User\Transformers\Administrator;

use App\Http\Resources\BaseResource;
use Illuminate\Http\Request;

class IndexItemResource extends BaseResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            /**
             * 账号
             * @var string
             */
            'account' => $this->account,
            /**
             * 昵称
             * @var string
             */
            'nickname' => $this->nickname,
            /**
             * 头像
             * @var string
             */
            'avatar' => $this->avatar,
        ];
    }
}
