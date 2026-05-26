<?php

namespace App\Support;

use Illuminate\Database\Eloquent\Builder;

abstract class QueryBuilder
{
    protected static function queryMapping(): array
    {
        return [];
    }


    /**
     * 应用查询
     *
     * @param  Builder $query
     * @param  array   $params
     * @return Builder
     */
    public static function apply(Builder $query, array $params): Builder
    {
        $query = static::beforeApply($query, $params);

        $mapping = static::queryMapping();

        foreach ($params as $key => $value) {
            if (! static::shouldApply($value, $params, $key)) {
                continue;
            }

            $handler = $mapping[$key] ?? null;

            if (! is_callable($handler)) {
                continue;
            }

            $query = $handler($query, $value, $params);
        }

        return static::afterApply($query, $params);
    }

    /**
     * 判断是否应该应用查询
     *
     * @param  mixed  $value
     * @param  array  $params
     * @param  string $key
     * @return bool
     */
    protected static function shouldApply(mixed $value, array $params, string $key): bool
    {
        if ($value === null) {
            return false;
        }

        if ($value === '') {
            return false;
        }

        if (is_array($value) && $value === []) {
            return false;
        }

        return true;
    }

    /**
     * 应用查询前
     *
     * @param  Builder $query
     * @param  array   $params
     * @return Builder
     */
    protected static function beforeApply(Builder $query, array $params): Builder
    {
        return $query;
    }

    /**
     * 应用查询后
     *
     * @param  Builder $query
     * @param  array   $params
     * @return Builder
     */
    protected static function afterApply(Builder $query, array $params): Builder
    {
        return $query;
    }
}
