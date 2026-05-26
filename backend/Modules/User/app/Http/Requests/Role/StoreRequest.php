<?php

namespace Modules\User\Http\Requests\Role;

use App\Http\Requests\BaseFormRequest;

class StoreRequest extends BaseFormRequest
{
    public function rules(): array
    {
        return [
            // 角色名称
            'name' => ['required', 'string', 'min:2', 'max:30'],
        ];
    }

    public function attributes(): array
    {
        return [
            'name' => __('user::attributes.role.name'),
        ];
    }

    public function authorize(): bool
    {
        return $this->user()?->can('user.role.store') ?? false;
    }
}
