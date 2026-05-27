<?php

namespace Modules\Shop\Http\Controllers\Administrator;

use Modules\Shop\Http\Controllers\AthleteController as Controller;
use Modules\Shop\Http\Requests\Athlete\IndexRequest;
use Modules\Shop\Http\Requests\Athlete\StoreRequest;
use Modules\Shop\Http\Requests\Athlete\UpdateRequest;
use Modules\Shop\Models\Athlete;
use Modules\Shop\Queries\AthleteQuery;
use Modules\Shop\Transformers\Athlete\FormResource;
use Modules\Shop\Transformers\Athlete\IndexResource;
use Modules\Shop\Transformers\Athlete\ShowResource;

class AthleteController extends Controller
{
    public function index(IndexRequest $request)
    {
        return new IndexResource(
            AthleteQuery::apply(Athlete::query(), $request->validated())
                ->paginate($request->page_size ?? config('pagination.default_page_size'))
        );
    }

    public function store(StoreRequest $request)
    {
        return new FormResource(Athlete::create($request->validated()));
    }

    public function show(Athlete $athlete)
    {
        $this->authorize('show', $athlete);

        return new ShowResource($athlete);
    }

    public function edit(Athlete $athlete)
    {
        $this->authorize('update', $athlete);

        return new FormResource($athlete);
    }

    public function update(UpdateRequest $request, Athlete $athlete)
    {
        $this->authorize('update', $athlete);

        $athlete->update($request->validated());

        return new FormResource($athlete);
    }

    public function destroy(string $ids)
    {
        $idList = array_values(array_filter(explode(',', $ids)));

        foreach (Athlete::whereIn('id', $idList)->get() as $athlete) {
            $this->authorize('destroy', $athlete);
            $athlete->delete();
        }

        return response()->noContent();
    }
}
