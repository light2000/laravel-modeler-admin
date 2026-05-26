<?php

namespace Modules\User\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Modules\User\Models\Role;

// Permission naming: {module}.{model}.{action}
class RolePolicy
{
    use HandlesAuthorization;
    public function show(AuthorizableContract $a, Role $role): bool
    {
        return $a->can('user.role.show');
    }
    public function update(AuthorizableContract $a, Role $role): bool
    {
        return $a->can('user.role.update');
    }
    public function assignPermissions(AuthorizableContract $a, Role $role): bool
    {
        return $a->can('user.role.assign_permissions');
    }
    public function destroy(AuthorizableContract $a, Role $role): bool
    {
        return $a->can('user.role.destroy');
    }
}
