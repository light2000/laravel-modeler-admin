<?php

namespace Modules\User\Http\Controllers\Administrator;

use Modules\User\Http\Controllers\UserController as Controller;
use Modules\User\Http\Requests\Administrator\IndexRequest;
use Modules\User\Http\Requests\Administrator\StoreRequest;
use Modules\User\Http\Requests\Administrator\UpdateRequest;
use Modules\User\Models\Administrator;
use Modules\User\Queries\AdministratorQuery;
use Modules\User\Transformers\Administrator\FormResource;
use Modules\User\Transformers\Administrator\IndexResource;
use Modules\User\Transformers\Administrator\ShowResource;

class AdministratorController extends Controller
{
    public function index(IndexRequest $request)
    {
        return new IndexResource(AdministratorQuery::apply(Administrator::query(), $request->validated())->paginate($request->page_size ?? config('pagination.default_page_size')));
    }
    public function store(StoreRequest $request)
    {
        $data = $request->validated();
        $roleIds = $data['role_ids'] ?? [];
        unset($data['role_ids']);

        $administrator = Administrator::create($data);
        $administrator->role()->sync($roleIds);

        return new FormResource($administrator);
    }
    public function show(Administrator $administrator)
    {
        $this->authorize('show', $administrator);

        return new ShowResource($administrator);
    }
    public function edit(Administrator $administrator)
    {
        $this->authorize('update', $administrator);

        return new FormResource($administrator);
    }

    public function update(UpdateRequest $request, Administrator $administrator)
    {
        $this->authorize('update', $administrator);

        $data = $request->validated();
        if (array_key_exists('role_ids', $data)) {
            $administrator->role()->sync($data['role_ids'] ?? []);
            unset($data['role_ids']);
        }

        if ($data !== []) {
            $administrator->update($data);
        }

        return new FormResource($administrator->fresh());
    }
    public function destroy(string $ids)
    {
        $idList = array_values(array_filter(explode(',', $ids)));

        foreach (Administrator::whereIn('id', $idList)->get() as $administrator) {
            $this->authorize('destroy', $administrator);
            $administrator->delete();
        }

        return response()->noContent();
    }
}
