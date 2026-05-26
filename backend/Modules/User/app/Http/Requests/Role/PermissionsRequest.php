<?php

namespace Modules\User\Http\Requests\Role;

use App\Http\Requests\BaseFormRequest;

class PermissionsRequest extends BaseFormRequest
{
    public function rules(): array
    {
        return [
            // 权限
            'permissions' => ['required', 'array'],
            'permissions.*' => ['string'],
        ];
    }

    public function attributes(): array
    {
        return [
            'permission' => __('user::permissions.user.permission'),
        ];
    }

    public function authorize(): bool
    {
        return $this->user()?->can('user.role.assign_permissions') ?? false;
    }
}
