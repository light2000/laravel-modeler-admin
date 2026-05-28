<?php

namespace Modules\Shop\Models;

use Illuminate\Database\Eloquent\Model;
use Modules\Shop\Models\_Generated\_OrderTrait;


class Order extends Model
{
    use _OrderTrait;
    protected $guarded = [];
}
