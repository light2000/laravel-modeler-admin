<?php

namespace Modules\User\Transformers\Role;

use App\Http\Resources\BaseCollection;

class IndexResource extends BaseCollection
{
    public $collects = \Modules\User\Transformers\Role\IndexItemResource::class;
}
