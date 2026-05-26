<?php

namespace Modules\Shop\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Modules\Shop\Models\Athlete;

class AthletePolicy
{
    use HandlesAuthorization;

    public function show(AuthorizableContract $a, Athlete $athlete): bool
    {
        return $a->can('shop.athlete.show');
    }

    public function update(AuthorizableContract $a, Athlete $athlete): bool
    {
        return $a->can('shop.athlete.update');
    }

    public function destroy(AuthorizableContract $a, Athlete $athlete): bool
    {
        return $a->can('shop.athlete.destroy');
    }
}
