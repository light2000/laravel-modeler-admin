<?php

namespace Modules\Shop\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Modules\Shop\Models\Actor;

class ActorPolicy
{
    use HandlesAuthorization;

    public function show(AuthorizableContract $a, Actor $actor): bool
    {
        return $a->can('shop.actor.show');
    }

    public function update(AuthorizableContract $a, Actor $actor): bool
    {
        return $a->can('shop.actor.update');
    }

    public function destroy(AuthorizableContract $a, Actor $actor): bool
    {
        return $a->can('shop.actor.destroy');
    }
}
