<?php

namespace Modules\User\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Modules\User\Models\Administrator;

// Permission naming: {module}.{model}.{action}
class AdministratorPolicy
{
    use HandlesAuthorization;
    public function show(AuthorizableContract $a, Administrator $administrator): bool
    {
        return $a->can('user.administrator.show');
    }
    public function update(AuthorizableContract $a, Administrator $administrator): bool
    {
        return $a->can('user.administrator.update');
    }
    public function destroy(AuthorizableContract $a, Administrator $administrator): bool
    {
        return $a->can('user.administrator.destroy');
    }
}
