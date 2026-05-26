<?php

namespace Modules\Shop\Transformers\Actor;

use App\Http\Resources\BaseCollection;

class IndexResource extends BaseCollection
{
    public $collects = \Modules\Shop\Transformers\Actor\IndexItemResource::class;
}
