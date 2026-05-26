<?php

namespace App\Http\Controllers;

use App\Http\Resources\OptionCollection;
use Illuminate\Http\Request;

class PolymorphicOptionsController extends Controller
{
    public function index(Request $request)
    {
        $request->validate([
            'type' => 'required|string',
            'for' => 'required|string',
            'id' => 'nullable|integer',
            'q' => 'nullable|string',
            'page' => 'nullable|integer|min:1',
            'page_size' => 'nullable|integer|min:1|max:100',
        ]);

        $type = $request->input('type');
        $for = $request->input('for');
        $id = $request->input('id');
        $keyword = $request->input('q');
        $pageSize = $request->input('page_size', config('pagination.default_page_size'));

        $config = [
            'actor' => [
                'product.spokesperson_id' => [
                    'name',
                ],
            ],
            'athlete' => [
                'product.spokesperson_id' => [
                    'name',
                ],
            ],
        ];

        if (!isset($config[$type])) {
            abort(400, "Invalid 'type' parameter: {$type}");
        }

        if (!isset($config[$type][$for])) {
            abort(400, "Invalid 'for' parameter: {$for}");
        }

        $displayAttrs = $config[$type][$for];

        // 根据type获取模型类
        $modelClass = $this->getModelClass($type);
        if (!$modelClass) {
            abort(400, "Model class not found for type: {$type}");
        }

        $query = $modelClass::query();

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

    private function getModelClass(string $type): ?string
    {
        return config('modeler.morph_map')[$type] ?? null;
    }
}
