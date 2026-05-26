<?php

namespace Modules\Shop\Http\Requests\Athlete;

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
            'height' => ['sometimes', 'nullable', 'numeric', 'min:0.5', 'max:2.5'],
            'weight' => ['sometimes', 'nullable', 'numeric', 'min:20', 'max:200'],
            'birthday' => ['sometimes', 'nullable', 'date'],
            'avatar' => ['sometimes', 'nullable', 'string', 'max:1024'],
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
        $athlete = $this->route('athlete');

        return $athlete ? ($this->user()?->can('update', $athlete) ?? false) : false;
    }
}
