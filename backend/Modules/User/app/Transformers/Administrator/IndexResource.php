<?php

namespace Modules\User\Transformers\Administrator;

use App\Http\Resources\BaseCollection;

class IndexResource extends BaseCollection
{
    public $collects = \Modules\User\Transformers\Administrator\IndexItemResource::class;
}
