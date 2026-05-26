<?php

namespace Modules\Shop\Models;

use Illuminate\Database\Eloquent\Model;
use Modules\Shop\Models\_Generated\_CategoryTrait;


class Category extends Model
{
    use _CategoryTrait;
    protected $guarded = [];
}
