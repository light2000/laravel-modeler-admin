<?php

namespace Modules\Shop\Http\Controllers\Administrator;

use Modules\Shop\Http\Controllers\ProductController as Controller;
use Modules\Shop\Http\Requests\Product\IndexRequest;
use Modules\Shop\Http\Requests\Product\StoreRequest;
use Modules\Shop\Http\Requests\Product\UpdateRequest;
use Modules\Shop\Models\Product;
use Modules\Shop\Queries\ProductQuery;
use Modules\Shop\Transformers\Product\FormResource;
use Modules\Shop\Transformers\Product\IndexResource;
use Modules\Shop\Transformers\Product\ShowResource;

class ProductController extends Controller
{
    public function index(IndexRequest $request)
    {
        return new IndexResource(
            ProductQuery::apply(Product::query()->with('category'), $request->validated())
                ->paginate($request->page_size ?? config('pagination.default_page_size'))
        );
    }

    public function store(StoreRequest $request)
    {
        return new FormResource(Product::create($request->validated()));
    }

    public function show(Product $product)
    {
        $this->authorize('show', $product);

        return new ShowResource($product->load('category'));
    }

    public function edit(Product $product)
    {
        $this->authorize('update', $product);

        return new FormResource($product);
    }

    public function update(UpdateRequest $request, Product $product)
    {
        $this->authorize('update', $product);

        $product->update($request->validated());

        return new FormResource($product);
    }

    public function destroy(Product $product)
    {
        $this->authorize('destroy', $product);
        $product->delete();

        return response()->noContent();
    }
}
