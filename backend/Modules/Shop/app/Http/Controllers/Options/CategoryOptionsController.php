<?php

namespace Modules\Shop\Http\Controllers\Options;

use App\Http\Resources\OptionCollection;
use Illuminate\Http\Request;
use Modules\Shop\Http\Controllers\ShopController;
use Modules\Shop\Models\Category;

class CategoryOptionsController extends ShopController
{
    public function index(Request $request)
    {
        $request->validate([
            'for' => 'required|string',
            'id' => 'nullable|integer',
            'q' => 'nullable|string',
            'page' => 'nullable|integer|min:1',
            'page_size' => 'nullable|integer|min:1|max:100',
        ]);

        $for = $request->input('for');
        $id = $request->input('id');
        $keyword = $request->input('q');
        $pageSize = $request->input('page_size', config('pagination.default_page_size'));

        $config = [
            'category.parent_id' => [
                'name',
            ],
            'product.category_id' => [
                'name',
            ],
        ];

        if (!isset($config[$for])) {
            abort(400, "Invalid 'for' parameter: {$for}");
        }

        $displayAttrs = $config[$for];

        $query = Category::query();

        // 如果指定了id，只返回该id的数据
        if (!empty($id)) {
            $query->where('id', $id);
        } else {
            // 只有在没有指定id时才应用搜索关键词
            if (!empty($keyword) && !empty($displayAttrs)) {
                $query->where(function ($q) use ($displayAttrs, $keyword) {
                    foreach ($displayAttrs as $index => $attr) {
                        if ($index === 0) {
                            $q->where($attr, 'like', "%{$keyword}%");
                        } else {
                            $q->orWhere($attr, 'like', "%{$keyword}%");
                        }
                    }
                });
            }
        }

        $paginator = $query->paginate($pageSize);

        $paginator->getCollection()->transform(function ($item) use ($displayAttrs) {
            $labelParts = [];
            foreach ($displayAttrs as $attr) {
                $value = $item->{$attr};
                if ($value !== null && $value !== '') {
                    $labelParts[] = $value;
                }
            }
            return [
                'value' => $item->id,
                'label' => !empty($labelParts) ? implode('/', $labelParts) : '#' . $item->id,
            ];
        });

        return new OptionCollection($paginator);
    }
}
