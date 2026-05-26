<?php

namespace Modules\Shop\Transformers\Category;

use App\Http\Resources\BaseCollection;

class IndexResource extends BaseCollection
{
    public $collects = \Modules\Shop\Transformers\Category\IndexItemResource::class;
}
