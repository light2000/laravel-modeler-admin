<?php

namespace Modules\User\Models;

use Modules\User\Models\_Generated\_TokenTrait;

use Laravel\Sanctum\PersonalAccessToken;

class Token extends PersonalAccessToken
{
    use _TokenTrait;

    protected $guarded = [];
    protected $hidden = [];

    public function casts(): array
    {
        return array_merge(parent::casts(), [
            'abilities' => 'json',
        ]);
    }
}
