<?php

namespace Modules\Shop\Http\Requests\Product;

use App\Http\Requests\BaseFormRequest;
use Illuminate\Validation\Rule;
use Modules\Shop\Enums\ProductLabel;
use Modules\Shop\Enums\ProductStatus;
use Modules\Shop\Models\Actor;
use Modules\Shop\Models\Athlete;

class StoreRequest extends BaseFormRequest
{
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'price' => ['required', 'numeric', 'min:0.01', 'max:999999.99'],
            'stock' => ['required', 'integer', 'min:0', 'max:10000'],
            'category_id' => ['required', 'integer', 'exists:categories,id'],
            'status' => ['required', Rule::in(ProductStatus::cases())],
            'photos' => ['nullable', 'array'],
            'photos.*' => ['string', 'max:255'],
            'label' => ['nullable', 'array'],
            'label.*' => [Rule::in(ProductLabel::cases())],
            'cover_image' => ['nullable', 'string', 'max:255'],
            'free_shipping' => ['nullable', 'boolean'],
            'detailed_information' => ['nullable', 'string'],
            'on_sale_time' => ['nullable', 'date'],
            'production_date' => ['nullable', 'date'],
            'spokesperson_id' => ['nullable', 'integer'],
            'spokesperson_type' => ['nullable', 'string', Rule::in(['actor', 'athlete'])],
        ];
    }

    public function attributes(): array
    {
        return [
            'name' => __('shop::attributes.product.name'),
            'description' => __('shop::attributes.product.description'),
            'price' => __('shop::attributes.product.price'),
            'stock' => __('shop::attributes.product.stock'),
            'category_id' => __('shop::attributes.product.category_id'),
            'status' => __('shop::attributes.product.status'),
            'photos' => __('shop::attributes.product.photos'),
            'label' => __('shop::attributes.product.label'),
            'cover_image' => __('shop::attributes.product.cover_image'),
            'free_shipping' => __('shop::attributes.product.free_shipping'),
            'detailed_information' => __('shop::attributes.product.detailed_information'),
            'on_sale_time' => __('shop::attributes.product.on_sale_time'),
            'production_date' => __('shop::attributes.product.production_date'),
            'spokesperson_id' => __('shop::attributes.product.spokesperson_id'),
            'spokesperson_type' => __('shop::attributes.product.spokesperson_type'),
        ];
    }

    public function authorize(): bool
    {
        return $this->user()?->can('shop.product.store') ?? false;
    }
}
