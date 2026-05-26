<?php

namespace Modules\User\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Modules\User\Models\User;

// Permission naming: {module}.{model}.{action}
class UserPolicy
{
    use HandlesAuthorization;
    public function show(AuthorizableContract $a, User $user): bool
    {
        return $a->can('user.user.show');
    }
    public function update(AuthorizableContract $a, User $user): bool
    {
        return $a->can('user.user.update');
    }
    public function destroy(AuthorizableContract $a, User $user): bool
    {
        return $a->can('user.user.destroy');
    }
}
