<?php

namespace Modules\Shop\Http\Requests\Category;

use App\Http\Requests\BaseFormRequest;
use App\Rules\SortRule;
use Illuminate\Validation\Rule;

class IndexRequest extends BaseFormRequest
{
    public function rules(): array
    {
        return [
            'name' => ['sometimes', 'string'],
            'parent_id' => ['sometimes', 'nullable', 'integer'],
            'page' => ['nullable', 'integer', 'min:1'],
            'page_size' => ['nullable', 'integer', Rule::in(config('pagination.page_size_options'))],
            'sort' => ['nullable', new SortRule(['created_at', 'sort_order', 'id'])],
        ];
    }

    public function attributes(): array
    {
        return [
            'name' => __('shop::attributes.category.name'),
            'parent_id' => __('shop::attributes.category.parent_id'),
            'page' => __('common.page'),
            'page_size' => __('common.page_size'),
            'sort' => __('common.sort'),
        ];
    }

    public function authorize(): bool
    {
        return $this->user()?->can('shop.category.index') ?? false;
    }
}
