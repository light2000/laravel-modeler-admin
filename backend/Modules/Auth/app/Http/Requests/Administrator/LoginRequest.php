<?php

namespace Modules\Auth\Http\Requests\Administrator;

use App\Http\Requests\BaseFormRequest;

class LoginRequest extends BaseFormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            // 账号
            'account' => ['required', 'string'],
            // 密码
            'password' => ['required', 'string'],
        ];
    }

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    public function attributes()
    {
        return [
            'account' => __('user::attributes.administrator.account'),
            'password' => __('user::attributes.administrator.password'),
        ];
    }
}
