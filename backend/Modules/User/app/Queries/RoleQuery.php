<?php

namespace Modules\User\Queries;

use App\Support\QueryBuilder;
use App\Support\QueryFilters;

class RoleQuery extends QueryBuilder
{
    protected static function queryMapping(): array
    {
        return  [
            'name' => QueryFilters::like('name'),
        ];
    }
}
