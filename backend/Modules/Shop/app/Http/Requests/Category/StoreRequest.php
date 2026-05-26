<?php

namespace Modules\Shop\Http\Requests\Category;

use App\Http\Requests\BaseFormRequest;

class StoreRequest extends BaseFormRequest
{
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:191', 'unique:categories,name'],
            'parent_id' => ['nullable', 'integer', 'exists:categories,id'],
            'sort_order' => ['required', 'integer', 'min:0', 'max:9999'],
            'icon' => ['nullable', 'string', 'max:255'],
        ];
    }

    public function attributes(): array
    {
        return [
            'name' => __('shop::attributes.category.name'),
            'parent_id' => __('shop::attributes.category.parent_id'),
            'sort_order' => __('shop::attributes.category.sort_order'),
            'icon' => __('shop::attributes.category.icon'),
        ];
    }

    public function authorize(): bool
    {
        return $this->user()?->can('shop.category.store') ?? false;
    }
}
