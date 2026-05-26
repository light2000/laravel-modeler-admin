<?php

namespace Modules\User\Http\Requests\Me;

use App\Http\Requests\BaseFormRequest;

class UpdatePasswordRequest extends BaseFormRequest
{
    public function rules(): array
    {
        return [
            // 旧密码
            'old_password' => ['required', 'string'],
            // 新密码
            'new_password' => ['required', 'string', 'min:6'],
        ];
    }

    public function attributes(): array
    {
        return [
            'old_password' => __('user::attributes.administrator.old_password'),
            'new_password' => __('user::attributes.administrator.new_password'),
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
