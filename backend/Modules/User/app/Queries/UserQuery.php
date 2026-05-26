<?php

namespace Modules\User\Queries;

use App\Support\QueryBuilder;
use App\Support\QueryFilters;

class UserQuery extends QueryBuilder
{
    protected static function queryMapping(): array
    {
        return  [
            'username' => QueryFilters::like('username'),
            'nickname' => QueryFilters::like('nickname'),
            'status' => QueryFilters::exact('status'),
        ];
    }
}
