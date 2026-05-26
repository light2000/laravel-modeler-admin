<?php

namespace Modules\User\Http\Requests\Role;

use App\Http\Requests\BaseFormRequest;

class UpdateRequest extends BaseFormRequest
{
    public function rules(): array
    {
        return [
            // 角色名称
            'name' => ['sometimes', 'nullable', 'string', 'min:2', 'max:30'],
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
        $role = $this->route('role');

        return $role ? ($this->user()?->can('update', $role) ?? false) : false;
    }
}
