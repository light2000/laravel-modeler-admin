<?php

namespace Modules\User\Http\Requests\User;

use App\Enums\UserStatus;
use App\Http\Requests\BaseFormRequest;
use Illuminate\Validation\Rule;

class StoreRequest extends BaseFormRequest
{
    public function rules(): array
    {
        return [
            // 账号
            'username' => ['required', 'string', 'min:3', 'max:50', 'email', 'unique:users,username'],
            // 密码
            'password' => ['required', 'string', 'min:6'],
            // 昵称
            'nickname' => ['required', 'string', 'min:1', 'max:30'],
            // 头像
            'avatar' => ['required', 'string', 'max:255'],
            // 用户状态
            'status' => ['nullable', Rule::in(UserStatus::cases())],
        ];
    }

    public function attributes(): array
    {
        return [
            'username' => __('user::attributes.user.username'),
            'password' => __('user::attributes.user.password'),
            'nickname' => __('user::attributes.user.nickname'),
            'avatar' => __('user::attributes.user.avatar'),
            'status' => __('user::attributes.user.status'),
        ];
    }

    public function authorize(): bool
    {
        return $this->user()?->can('user.user.store') ?? false;
    }
}
