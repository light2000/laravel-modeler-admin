<?php

namespace App\Support;

use Illuminate\Database\Eloquent\Builder;

class QueryFilters
{
    public static function exact(string $column): callable
    {
        return fn(Builder $query, mixed $value) => $query->where($column, $value);
    }

    public static function like(string $column): callable
    {
        return fn(Builder $query, mixed $value) => $query->where($column, 'like', '%' . $value . '%');
    }

    public static function jsonContains(string $column): callable
    {
        return fn(Builder $query, $value) => $query->whereJsonContains($column, $value);
    }

    public static function boolean(string $column): callable
    {
        return function (Builder $query, mixed $value) use ($column) {
            $bool = filter_var($value, FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE);

            if ($bool === null) {
                return $query;
            }

            return $query->where($column, $bool);
        };
    }

    public static function in(string $column): callable
    {
        return function (Builder $query, mixed $value) use ($column) {
            $values = is_array($value) ? $value : explode(',', (string) $value);
            $values = array_values(array_filter($values, fn($v) => $v !== '' && $v !== null));

            if ($values === []) {
                return $query;
            }

            return $query->whereIn($column, $values);
        };
    }

    public static function min(string $column): callable
    {
        return fn(Builder $query, mixed $value) => $query->where($column, '>=', $value);
    }

    public static function max(string $column): callable
    {
        return fn(Builder $query, mixed $value) => $query->where($column, '<=', $value);
    }

    public static function between(string $column): callable
    {
        return function (Builder $query, mixed $value) use ($column) {
            if (! is_array($value) || count($value) !== 2) {
                return $query;
            }

            [$start, $end] = $value;

            if ($start === null || $start === '' || $end === null || $end === '') {
                return $query;
            }

            return $query->whereBetween($column, [$start, $end]);
        };
    }

    public static function keyword(array $columns): callable
    {
        return function (Builder $query, mixed $value) use ($columns) {
            return $query->where(function (Builder $subQuery) use ($columns, $value) {
                foreach ($columns as $index => $column) {
                    if ($index === 0) {
                        $subQuery->where($column, 'like', '%' . $value . '%');
                    } else {
                        $subQuery->orWhere($column, 'like', '%' . $value . '%');
                    }
                }
            });
        };
    }
}
