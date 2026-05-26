<?php

namespace Modules\Shop\Http\Requests\Athlete;

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
            'height' => ['nullable', 'numeric', 'min:0.5', 'max:2.5'],
            'weight' => ['nullable', 'numeric', 'min:20', 'max:200'],
            'birthday' => ['nullable', 'date'],
            'avatar' => ['nullable', 'string', 'max:1024'],
        ];
    }

    public function attributes(): array
    {
        return [
            'name' => __('shop::attributes.athlete.name'),
            'gender' => __('shop::attributes.athlete.gender'),
            'height' => __('shop::attributes.athlete.height'),
            'weight' => __('shop::attributes.athlete.weight'),
            'birthday' => __('shop::attributes.athlete.birthday'),
            'avatar' => __('shop::attributes.athlete.avatar'),
        ];
    }

    public function authorize(): bool
    {
        return $this->user()?->can('shop.athlete.store') ?? false;
    }
}
