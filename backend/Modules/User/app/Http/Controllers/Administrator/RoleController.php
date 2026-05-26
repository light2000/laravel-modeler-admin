<?php

namespace Modules\User\Http\Controllers\Administrator;

use Modules\User\Http\Controllers\UserController as Controller;
use Modules\User\Http\Requests\Role\IndexRequest;
use Modules\User\Http\Requests\Role\PermissionsRequest;
use Modules\User\Http\Requests\Role\StoreRequest;
use Modules\User\Http\Requests\Role\UpdateRequest;
use Modules\User\Models\Role;
use Modules\User\Queries\RoleQuery;
use Modules\User\Transformers\Role\FormResource;
use Modules\User\Transformers\Role\IndexResource;
use Modules\User\Transformers\Role\PermissionsResource;
use Modules\User\Transformers\Role\ShowResource;

class RoleController extends Controller
{
    public function index(IndexRequest $request)
    {
        return new IndexResource(RoleQuery::apply(Role::query(), $request->validated())->paginate($request->page_size ?? config('pagination.default_page_size')));
    }
    public function store(StoreRequest $request)
    {
        return new FormResource(Role::create($request->validated()));
    }
    public function show(Role $role)
    {
        $this->authorize('show', $role);

        return new ShowResource($role);
    }
    public function edit(Role $role)
    {
        $this->authorize('update', $role);

        return new FormResource($role);
    }

    public function update(UpdateRequest $request, Role $role)
    {
        $this->authorize('update', $role);

        $role->update($request->validated());

        return new FormResource($role);
    }
    public function destroy(Role $role)
    {
        $this->authorize('destroy', $role);
        $role->name = $role->name . '#deleted#' . $role->id;
        $role->save();
        $role->delete();

        return response()->noContent();
    }
    public function updatePermissions(PermissionsRequest $request, Role $role)
    {
        $this->authorize('assignPermissions', $role);
        $params = $request->validated();
        $role->syncPermissions(\Modules\User\Models\Permission::whereIn('name', $params['permissions'])->pluck('id')->toArray());

        return new PermissionsResource($role);
    }

    public function editPermissions(Role $role)
    {
        $this->authorize('assignPermissions', $role);
        $role['permissions'] = $role->getAllPermissions()->pluck('name')->values();
        return new PermissionsResource($role);
    }
}
