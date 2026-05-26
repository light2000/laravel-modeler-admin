<?php

namespace Modules\Shop\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Modules\Shop\Models\Product;

class ProductPolicy
{
    use HandlesAuthorization;

    public function show(AuthorizableContract $a, Product $product): bool
    {
        return $a->can('shop.product.show');
    }

    public function update(AuthorizableContract $a, Product $product): bool
    {
        return $a->can('shop.product.update');
    }

    public function destroy(AuthorizableContract $a, Product $product): bool
    {
        return $a->can('shop.product.destroy');
    }
}
