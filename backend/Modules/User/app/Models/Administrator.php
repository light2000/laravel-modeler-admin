<?php

namespace Modules\User\Models;

use Modules\User\Models\_Generated\_AdministratorTrait;
use App\Enums\UserStatus;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Foundation\Auth\Access\Authorizable;

class Administrator extends Authenticatable implements AuthorizableContract
{
    use _AdministratorTrait;
    use HasApiTokens;
    use Authorizable;
    use HasRoles;

    protected $guarded = [];

    public $attributes = ['status'=> UserStatus::Active];
    
    protected function casts(): array
    {
        return [
            'status' => UserStatus::class,
            'account' => 'string',
            'password' => 'hashed',
            'nickname' => 'string',
            'avatar' => 'string',
        ];
    }
}
