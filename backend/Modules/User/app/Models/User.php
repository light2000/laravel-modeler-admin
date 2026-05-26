<?php

namespace Modules\User\Models;

use Modules\User\Models\_Generated\_UserTrait;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;

class User extends Authenticatable implements AuthorizableContract
{
    use _UserTrait;
    use HasApiTokens;
    use Authorizable;

    protected $guarded = [];
}
