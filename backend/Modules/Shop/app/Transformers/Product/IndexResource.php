<?php

namespace Modules\Shop\Transformers\Product;

use App\Http\Resources\BaseCollection;

class IndexResource extends BaseCollection
{
    public $collects = \Modules\Shop\Transformers\Product\IndexItemResource::class;
}
