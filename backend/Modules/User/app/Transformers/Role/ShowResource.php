<?php

namespace Modules\User\Transformers\Role;

use App\Http\Resources\BaseResource;
use Illuminate\Http\Request;

class ShowResource extends BaseResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            /**
             * 角色名称
             * @var string
             */
            'name' => $this->name,
        ];
    }
}
