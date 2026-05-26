<?php

namespace Modules\User\Transformers\User;

use App\Http\Resources\BaseCollection;

class IndexResource extends BaseCollection
{
    public $collects = \Modules\User\Transformers\User\IndexItemResource::class;
}
