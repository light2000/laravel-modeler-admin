<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;

class OptionResource extends BaseResource
{
    public function toArray(Request $request): array
    {
        return [
            'value' => $this->resource['value'] ?? null,
            'label' => $this->resource['label'] ?? '',
        ];
    }
}
