<?php

namespace Modules\User\Models;

use Illuminate\Database\Eloquent\Model;
use Modules\User\Models\_Generated\_PermissionTrait;


class Permission extends \Spatie\Permission\Models\Permission
{
    use _PermissionTrait;
    protected $guarded = [];
}
