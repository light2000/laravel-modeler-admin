<?php

namespace Modules\User\Http\Controllers\Administrator;

use Modules\User\Http\Controllers\UserController as Controller;
use Modules\User\Http\Requests\User\IndexRequest;
use Modules\User\Http\Requests\User\StoreRequest;
use Modules\User\Http\Requests\User\UpdateRequest;
use Modules\User\Models\User;
use Modules\User\Queries\UserQuery;
use Modules\User\Transformers\User\FormResource;
use Modules\User\Transformers\User\IndexResource;
use Modules\User\Transformers\User\ShowResource;

class UserController extends Controller
{
    public function index(IndexRequest $request)
    {
        return new IndexResource(UserQuery::apply(User::query(), $request->validated())->paginate($request->page_size ?? config('pagination.default_page_size')));
    }
    public function store(StoreRequest $request)
    {
        return new FormResource(User::create($request->validated()));
    }
    public function show(User $user)
    {
        $this->authorize('show', $user);

        return new ShowResource($user);
    }
    public function edit(User $user)
    {
        $this->authorize('update', $user);

        return new FormResource($user);
    }

    public function update(UpdateRequest $request, User $user)
    {
        $this->authorize('update', $user);

        $user->update($request->validated());

        return new FormResource($user);
    }
    public function destroy(User $user)
    {
        $this->authorize('destroy', $user);
        $user->delete();

        return response()->noContent();
    }
}
