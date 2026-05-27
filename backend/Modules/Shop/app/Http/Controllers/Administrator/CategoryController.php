<?php

namespace Modules\Shop\Http\Controllers\Administrator;

use Modules\Shop\Http\Controllers\CategoryController as Controller;
use Modules\Shop\Http\Requests\Category\IndexRequest;
use Modules\Shop\Http\Requests\Category\StoreRequest;
use Modules\Shop\Http\Requests\Category\UpdateRequest;
use Modules\Shop\Models\Category;
use Modules\Shop\Queries\CategoryQuery;
use Modules\Shop\Transformers\Category\FormResource;
use Modules\Shop\Transformers\Category\IndexResource;
use Modules\Shop\Transformers\Category\ShowResource;

class CategoryController extends Controller
{
    public function index(IndexRequest $request)
    {
        return new IndexResource(
            CategoryQuery::apply(Category::query()->with('parent'), $request->validated())
                ->paginate($request->page_size ?? config('pagination.default_page_size'))
        );
    }

    public function store(StoreRequest $request)
    {
        return new FormResource(Category::create($request->validated()));
    }

    public function show(Category $category)
    {
        $this->authorize('show', $category);

        return new ShowResource($category->load('parent'));
    }

    public function edit(Category $category)
    {
        $this->authorize('update', $category);

        return new FormResource($category);
    }

    public function update(UpdateRequest $request, Category $category)
    {
        $this->authorize('update', $category);

        $category->update($request->validated());

        return new FormResource($category);
    }

    public function destroy(string $ids)
    {
        $idList = array_values(array_filter(explode(',', $ids)));

        foreach (Category::whereIn('id', $idList)->get() as $category) {
            $this->authorize('destroy', $category);
            $category->delete();
        }

        return response()->noContent();
    }
}
