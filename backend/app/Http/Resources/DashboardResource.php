<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;

class DashboardResource extends BaseResource
{
    /**
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        /** @var array<string, mixed> $payload */
        $payload = $this->resource;

        return $payload;
    }
}
