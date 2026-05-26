<?php

namespace Modules\User\Transformers\Role;

use App\Http\Resources\BaseResource;
use Illuminate\Http\Request;

class PermissionsResource extends BaseResource
{
    public function toArray(Request $request): array
    {
        return [
            /**
             * 角色
             * @var array<string>
             */
            'permissions' => $this['permissions'],
        ];
    }
}
