<?php

namespace Modules\Shop\Queries;

use App\Support\QueryBuilder;
use App\Support\QueryFilters;

class ActorQuery extends QueryBuilder
{
    protected static function queryMapping(): array
    {
        return [
            'name' => QueryFilters::like('name'),
            'gender' => QueryFilters::exact('gender'),
            'nationality' => QueryFilters::like('nationality'),
        ];
    }
}
