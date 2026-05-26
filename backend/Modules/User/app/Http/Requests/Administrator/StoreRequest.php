<?php

namespace Modules\User\Http\Requests\Administrator;
use App\Http\Requests\BaseFormRequest;

class StoreRequest extends BaseFormRequest
{
    public function rules(): array
    {
        return [
            // 账号
            'account' => ['required', 'string', 'min:3', 'max:50', 'email', 'unique:administrators,account'],
            // 密码
            'password' => ['required', 'string', 'min:6'],
            // 昵称
            'nickname' => ['required', 'string', 'min:1', 'max:30'],
            // 头像
            'avatar' => ['required', 'string', 'max:255'],
        ];
    }

    public function attributes(): array
    {
        return [
            'account' => __('user::attributes.administrator.account'),
            'password' => __('user::attributes.administrator.password'),
            'nickname' => __('user::attributes.administrator.nickname'),
            'avatar' => __('user::attributes.administrator.avatar'),
        ];
    }

    public function authorize(): bool
    {
        return $this->user()?->can('user.administrator.store') ?? false;
    }
}
