<?php

namespace Modules\Auth\Transformers\Administrator;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Modules\User\Transformers\Administrator\ProfileResource;

class LoginResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray(Request $request): array
    {
        return [
            /**
             * 管理员
             */
            'administrator' => new ProfileResource($this['administrator']),
            /**
             * 权限
             * @var array<string>
             */
            'permissions' => $this['permissions'],
            /**
             * 用户Token
             */
            'token' => $this['token'],
        ];
    }
}
