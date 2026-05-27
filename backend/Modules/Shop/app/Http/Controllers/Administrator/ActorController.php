<?php

namespace Modules\Shop\Http\Controllers\Administrator;

use Modules\Shop\Http\Controllers\ActorController as Controller;
use Modules\Shop\Http\Requests\Actor\IndexRequest;
use Modules\Shop\Http\Requests\Actor\StoreRequest;
use Modules\Shop\Http\Requests\Actor\UpdateRequest;
use Modules\Shop\Models\Actor;
use Modules\Shop\Queries\ActorQuery;
use Modules\Shop\Transformers\Actor\FormResource;
use Modules\Shop\Transformers\Actor\IndexResource;
use Modules\Shop\Transformers\Actor\ShowResource;

class ActorController extends Controller
{
    public function index(IndexRequest $request)
    {
        return new IndexResource(
            ActorQuery::apply(Actor::query(), $request->validated())
                ->paginate($request->page_size ?? config('pagination.default_page_size'))
        );
    }

    public function store(StoreRequest $request)
    {
        return new FormResource(Actor::create($request->validated()));
    }

    public function show(Actor $actor)
    {
        $this->authorize('show', $actor);

        return new ShowResource($actor);
    }

    public function edit(Actor $actor)
    {
        $this->authorize('update', $actor);

        return new FormResource($actor);
    }

    public function update(UpdateRequest $request, Actor $actor)
    {
        $this->authorize('update', $actor);

        $actor->update($request->validated());

        return new FormResource($actor);
    }

    public function destroy(string $ids)
    {
        $idList = array_values(array_filter(explode(',', $ids)));

        foreach (Actor::whereIn('id', $idList)->get() as $actor) {
            $this->authorize('destroy', $actor);
            $actor->delete();
        }

        return response()->noContent();
    }
}
