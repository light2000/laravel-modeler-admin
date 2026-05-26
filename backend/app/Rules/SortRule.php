<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Translation\PotentiallyTranslatedString;

class SortRule implements ValidationRule
{
        /**
     * @var array<string>
     */
    protected array $allowed;

    /**
     * @param array<string> $allowed 允许排序的字段白名单
     */
    public function __construct(array $allowed)
    {
        $this->allowed = $allowed;
    }

    /**
     * Run the validation rule.
     *
     * @param  Closure(string, ?string=): PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $fields = array_filter(explode(',', $value));

        if (empty($fields)) {
            $fail(__('validation.sort_invalid'));

            return;
        }

        foreach ($fields as $field) {
            $name = ltrim($field, '-');

            if (! in_array($name, $this->allowed, true)) {
                $fail(__('validation.sort_invalid'));
            }
        }
    }
}
