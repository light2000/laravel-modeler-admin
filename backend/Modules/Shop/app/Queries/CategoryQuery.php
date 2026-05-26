<?php

namespace Modules\Shop\Queries;

use App\Support\QueryBuilder;
use App\Support\QueryFilters;

class CategoryQuery extends QueryBuilder
{
    protected static function queryMapping(): array
    {
        return [
            'name' => QueryFilters::like('name'),
            'parent_id' => QueryFilters::exact('parent_id'),
        ];
    }
}
