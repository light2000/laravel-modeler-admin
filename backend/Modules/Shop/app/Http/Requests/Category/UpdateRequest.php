<?php

namespace Modules\Shop\Http\Requests\Category;

use App\Http\Requests\BaseFormRequest;

class UpdateRequest extends BaseFormRequest
{
    public function rules(): array
    {
        return [
            'name' => ['sometimes', 'nullable', 'string', 'max:191', 'unique:categories,name,' . $this->route('category')?->id],
            'parent_id' => ['sometimes', 'nullable', 'integer', 'exists:categories,id'],
            'sort_order' => ['sometimes', 'nullable', 'integer', 'min:0', 'max:9999'],
            'icon' => ['sometimes', 'nullable', 'string', 'max:255'],
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
        $category = $this->route('category');

        return $category ? ($this->user()?->can('update', $category) ?? false) : false;
    }
}
