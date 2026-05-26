<?php

namespace Modules\User\Http\Requests\Administrator;

use App\Http\Requests\BaseFormRequest;

class UpdateRequest extends BaseFormRequest
{
    public function rules(): array
    {
        return [
            // 账号
            'account' => ['sometimes', 'nullable', 'string', 'min:3', 'max:50', 'email', 'unique:administrators,account,' . $this->route('administrator')?->id],
            // 昵称
            'nickname' => ['sometimes', 'nullable', 'string', 'min:1', 'max:30'],
            // 头像
            'avatar' => ['sometimes', 'nullable', 'string', 'max:255'],
        ];
    }

    public function attributes(): array
    {
        return [
            'account' => __('user::attributes.administrator.account'),
            'nickname' => __('user::attributes.administrator.nickname'),
            'avatar' => __('user::attributes.administrator.avatar'),
        ];
    }

    public function authorize(): bool
    {
        $administrator = $this->route('administrator');

        return $administrator ? ($this->user()?->can('update', $administrator) ?? false) : false;
    }
}
