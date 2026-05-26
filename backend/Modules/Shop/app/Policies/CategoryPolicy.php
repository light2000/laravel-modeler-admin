<?php

namespace Modules\Shop\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Modules\Shop\Models\Category;

class CategoryPolicy
{
    use HandlesAuthorization;

    public function show(AuthorizableContract $a, Category $category): bool
    {
        return $a->can('shop.category.show');
    }

    public function update(AuthorizableContract $a, Category $category): bool
    {
        return $a->can('shop.category.update');
    }

    public function destroy(AuthorizableContract $a, Category $category): bool
    {
        return $a->can('shop.category.destroy');
    }
}
