<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

abstract class BaseCollection extends ResourceCollection
{
    public $collects = BaseResource::class;

    public $with = ['success' => true, 'code' => 'SUCCESS', 'message' => 'OK'];

    public function toArray($request): array
    {
        return [
            'rows' => $this->collection,
            'total' => (int) $this->resource->total(),
        ];
    }

    public static function paginationInformation($request, $paginated, $default): array
    {
        return [];
    }
}
