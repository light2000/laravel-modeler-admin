<?php

namespace Modules\Shop\Queries;

use App\Support\QueryBuilder;
use App\Support\QueryFilters;

class ProductQuery extends QueryBuilder
{
    protected static function queryMapping(): array
    {
        return [
            'name' => QueryFilters::like('name'),
            'category_id' => QueryFilters::exact('category_id'),
            'status' => QueryFilters::exact('status'),
            'free_shipping' => QueryFilters::boolean('free_shipping'),
        ];
    }
}
