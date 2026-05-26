<?php

namespace Modules\User\Http\Requests\Role;

use App\Http\Requests\BaseFormRequest;
use App\Rules\SortRule;
use Illuminate\Validation\Rule;

class IndexRequest extends BaseFormRequest
{
    public function rules(): array
    {
        return [
            // 角色名称
            'name' => ['sometimes', 'string'],
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
            'name' => __('user::attributes.role.name'),
            'page' => __('common.page'),
            'page_size' => __('common.page_size'),
            'sort' => __('common.sort'),
        ];
    }

    public function authorize(): bool
    {
        return $this->user()?->can('user.role.index') ?? false;
    }
}
