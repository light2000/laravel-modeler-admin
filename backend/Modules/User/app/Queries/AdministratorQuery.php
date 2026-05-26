<?php

namespace Modules\User\Queries;

use App\Support\QueryBuilder;
use App\Support\QueryFilters;

class AdministratorQuery extends QueryBuilder
{
    protected static function queryMapping(): array
    {
        return  [
            'account' => QueryFilters::like('account'),
            'nickname' => QueryFilters::like('nickname'),
        ];
    }
}
