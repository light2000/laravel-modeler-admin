<?php

namespace Modules\User\Http\Requests\User;

use App\Enums\UserStatus;
use App\Http\Requests\BaseFormRequest;
use App\Rules\SortRule;
use Illuminate\Validation\Rule;

class IndexRequest extends BaseFormRequest
{
    public function rules(): array
    {
        return [
            // 账号
            'username' => ['sometimes', 'string'],
            // 昵称
            'nickname' => ['sometimes', 'string'],
            // 用户状态
            'status' => ['sometimes', Rule::in(UserStatus::cases())],
            // 页码
            'page' => ['nullable', 'integer', 'min:1'],
            // 分页大小
            'page_size' => ['nullable', 'integer', Rule::in(config('pagination.page_size_options'))],
            // 排序
            'sort' => ['nullable', new SortRule([])],
        ];
    }

    public function attributes(): array
    {
        return [
            'username' => __('user::attributes.user.username'),
            'nickname' => __('user::attributes.user.nickname'),
            'status' => __('user::attributes.user.status'),
            'page' => __('common.page'),
            'page_size' => __('common.page_size'),
            'sort' => __('common.sort'),
        ];
    }

    public function authorize(): bool
    {
        return $this->user()?->can('user.user.index') ?? false;
    }
}
