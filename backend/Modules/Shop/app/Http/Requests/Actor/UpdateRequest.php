<?php

namespace Modules\Shop\Http\Requests\Actor;

use App\Enums\Gender;
use App\Http\Requests\BaseFormRequest;
use Illuminate\Validation\Rule;

class UpdateRequest extends BaseFormRequest
{
    public function rules(): array
    {
        return [
            'name' => ['sometimes', 'nullable', 'string', 'max:255'],
            'gender' => ['sometimes', 'nullable', Rule::in(Gender::cases())],
            'birth_date' => ['sometimes', 'nullable', 'date'],
            'nationality' => ['sometimes', 'nullable', 'string', 'max:255'],
            'avatar' => ['sometimes', 'nullable', 'string', 'max:1024'],
            'biography' => ['sometimes', 'nullable', 'string'],
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
        $actor = $this->route('actor');

        return $actor ? ($this->user()?->can('update', $actor) ?? false) : false;
    }
}
