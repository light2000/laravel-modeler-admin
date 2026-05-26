<?php

namespace Modules\Shop\Transformers\Athlete;

use App\Http\Resources\BaseCollection;

class IndexResource extends BaseCollection
{
    public $collects = \Modules\Shop\Transformers\Athlete\IndexItemResource::class;
}
