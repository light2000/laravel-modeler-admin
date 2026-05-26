<?php

namespace Modules\Shop\Models;

use Illuminate\Database\Eloquent\Model;
use Modules\Shop\Models\_Generated\_ProductTrait;


class Product extends Model
{
    use _ProductTrait;
    protected $guarded = [];
}
