<?php

namespace Modules\User\Models;

use Modules\User\Models\_Generated\_RoleTrait;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Role extends \Spatie\Permission\Models\Role
{
    use _RoleTrait;
    protected $guarded = [];
    protected $hidden = [];

    public function permissions(): BelongsToMany
    {
        return parent::permissions();
    }
}
