<?php

namespace Modules\User\Http\Requests\User;

use App\Enums\UserStatus;
use App\Http\Requests\BaseFormRequest;
use Illuminate\Validation\Rule;

class UpdateRequest extends BaseFormRequest
{
    public function rules(): array
    {
        return [
            // 账号
            'username' => ['sometimes', 'nullable', 'string', 'min:3', 'max:50', 'email', 'unique:users,username,' . $this->route('user')?->id],
            // 昵称
            'nickname' => ['sometimes', 'nullable', 'string', 'min:1', 'max:30'],
            // 头像
            'avatar' => ['sometimes', 'nullable', 'string', 'max:255'],
            // 用户状态
            'status' => ['sometimes', 'nullable', Rule::in(UserStatus::cases())],
        ];
    }

    public function attributes(): array
    {
        return [
            'username' => __('user::attributes.user.username'),
            'nickname' => __('user::attributes.user.nickname'),
            'avatar' => __('user::attributes.user.avatar'),
            'status' => __('user::attributes.user.status'),
        ];
    }

    public function authorize(): bool
    {
        $user = $this->route('user');

        return $user ? ($this->user()?->can('update', $user) ?? false) : false;
    }
}
