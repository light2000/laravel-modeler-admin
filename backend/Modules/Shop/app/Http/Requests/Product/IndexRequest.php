<?php

namespace Modules\Shop\Http\Requests\Product;

use App\Http\Requests\BaseFormRequest;
use App\Rules\SortRule;
use Illuminate\Validation\Rule;
use Modules\Shop\Enums\ProductStatus;

class IndexRequest extends BaseFormRequest
{
    public function rules(): array
    {
        return [
            'name' => ['sometimes', 'string'],
            'category_id' => ['sometimes', 'integer'],
            'status' => ['sometimes', Rule::in(ProductStatus::cases())],
            'free_shipping' => ['sometimes', 'boolean'],
            'page' => ['nullable', 'integer', 'min:1'],
            'page_size' => ['nullable', 'integer', Rule::in(config('pagination.page_size_options'))],
            'sort' => ['nullable', new SortRule(['created_at', 'id'])],
        ];
    }

    public function attributes(): array
    {
        return [
            'name' => __('shop::attributes.product.name'),
            'category_id' => __('shop::attributes.product.category_id'),
            'status' => __('shop::attributes.product.status'),
            'free_shipping' => __('shop::attributes.product.free_shipping'),
            'page' => __('common.page'),
            'page_size' => __('common.page_size'),
            'sort' => __('common.sort'),
        ];
    }

    public function authorize(): bool
    {
        return $this->user()?->can('shop.product.index') ?? false;
    }
}
