<?php

namespace Modules\Shop\Http\Requests\Actor;

use App\Enums\Gender;
use App\Http\Requests\BaseFormRequest;
use Illuminate\Validation\Rule;

class StoreRequest extends BaseFormRequest
{
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'gender' => ['nullable', Rule::in(Gender::cases())],
            'birth_date' => ['nullable', 'date'],
            'nationality' => ['nullable', 'string', 'max:255'],
            'avatar' => ['nullable', 'string', 'max:1024'],
            'biography' => ['nullable', 'string'],
        ];
    }

    public function attributes(): array
    {
        return [
            'name' => __('shop::attributes.actor.name'),
            'gender' => __('shop::attributes.actor.gender'),
            'birth_date' => __('shop::attributes.actor.birth_date'),
            'nationality' => __('shop::attributes.actor.nationality'),
            'avatar' => __('shop::attributes.actor.avatar'),
            'biography' => __('shop::attributes.actor.biography'),
        ];
    }

    public function authorize(): bool
    {
        return $this->user()?->can('shop.actor.store') ?? false;
    }
}
