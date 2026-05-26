<?php

namespace Modules\User\Http\Requests\Administrator;

use App\Http\Requests\BaseFormRequest;
use Illuminate\Validation\Rule;
use App\Rules\SortRule;

class IndexRequest extends BaseFormRequest
{
    public function rules(): array
    {
        return [
            // 账号
            'account' => ['sometimes', 'string'],
            // 昵称
            'nickname' => ['sometimes', 'string'],
            // 页码
            'page' => ["nullable", "integer", "min:1"],
            // 分页大小
            'page_size' => ["nullable", "integer", Rule::in(config("pagination.page_size_options"))],
            // 排序
            'sort' => ["nullable", new SortRule(['created_at'])],
        ];
    }

    public function attributes(): array
    {
        return [
            'account' => __('user::attributes.administrator.account'),
            'nickname' => __('user::attributes.administrator.nickname'),
            'page' => __('common.page'),
            'page_size' => __('common.page_size'),
            'sort' => __('common.sort'),
        ];
    }

    public function authorize(): bool
    {
        return $this->user()?->can('user.administrator.index') ?? false;
    }
}
