<?php

namespace Modules\Shop\Http\Requests\Athlete;

use App\Enums\Gender;
use App\Http\Requests\BaseFormRequest;
use App\Rules\SortRule;
use Illuminate\Validation\Rule;

class IndexRequest extends BaseFormRequest
{
    public function rules(): array
    {
        return [
            'name' => ['sometimes', 'string'],
            'gender' => ['sometimes', Rule::in(Gender::cases())],
            'page' => ['nullable', 'integer', 'min:1'],
            'page_size' => ['nullable', 'integer', Rule::in(config('pagination.page_size_options'))],
            'sort' => ['nullable', new SortRule(['created_at', 'id'])],
        ];
    }

    public function attributes(): array
    {
        return [
            'name' => __('shop::attributes.athlete.name'),
            'gender' => __('shop::attributes.athlete.gender'),
            'page' => __('common.page'),
            'page_size' => __('common.page_size'),
            'sort' => __('common.sort'),
        ];
    }

    public function authorize(): bool
    {
        return $this->user()?->can('shop.athlete.index') ?? false;
    }
}
