<?php

namespace Modules\Shop\Http\Requests\Actor;

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
            'nationality' => ['sometimes', 'string'],
            'page' => ['nullable', 'integer', 'min:1'],
            'page_size' => ['nullable', 'integer', Rule::in(config('pagination.page_size_options'))],
            'sort' => ['nullable', new SortRule(['created_at', 'id'])],
        ];
    }

    public function attributes(): array
    {
        return [
            'name' => __('shop::attributes.actor.name'),
            'gender' => __('shop::attributes.actor.gender'),
            'nationality' => __('shop::attributes.actor.nationality'),
            'page' => __('common.page'),
            'page_size' => __('common.page_size'),
            'sort' => __('common.sort'),
        ];
    }

    public function authorize(): bool
    {
        return $this->user()?->can('shop.actor.index') ?? false;
    }
}
