<?php
/*
|--------------------------------------------------------------------------
|  ⚠️ 提示 ⚠️
|--------------------------------------------------------------------------
| 此文件由laravel-modeler自动生成，请勿直接手动修改。
| 如需调整，请在laravel-modeler修改/设计后重新生成。
|--------------------------------------------------------------------------
*/
namespace Modules\Shop\Database\Seeders\_Generated;

use Modules\Shop\Models\Category;
use Illuminate\Database\Seeder;
use Modules\Shop\Models\Product;
use Illuminate\Support\Facades\Log;

class CategoryRelationSeeder extends Seeder
{
    public function run(): void
    {
        $categoryList = Category::orderBy('id')->get();
        $totalCount = count($categoryList);
        $L1 = max(1, floor(pow($totalCount, 1/3)));
        $L2 = $L1 * $L1;

        $level1 = $categoryList->slice(0, $L1)->values();
        $level2 = $categoryList->slice($L1, $L2)->values();
        $level3 = $categoryList->slice($L1 + $L2)->values();

        $index2 = 0;
        $index3 = 0;
        foreach ($level1 as $i => $node1) {
            $node1->parent_id = 0;
            $node1->save();

            for ($j = 0; $j < $L1 && $index2 < count($level2); $j++, $index2++) {
                $node2 = $level2[$index2];
                $node2->parent_id = $node1->id;
                $node2->save();

                for ($k = 0; $k < $L1 && $index3 < count($level3); $k++, $index3++) {
                    $node3 = $level3[$index3];
                    $node3->parent_id = $node2->id;
                    $node3->save();
                }
            }
        }
        $L1 = max(1, floor(pow($totalCount, 1/3)));
        $L2 = $L1 * $L1;

        $level1 = $categoryList->slice(0, $L1)->values();
        $level2 = $categoryList->slice($L1, $L2)->values();
        $level3 = $categoryList->slice($L1 + $L2)->values();

        $index2 = 0;
        $index3 = 0;
        foreach ($level1 as $i => $node1) {
            $node1->parent_id = 0;
            $node1->save();

            for ($j = 0; $j < $L1 && $index2 < count($level2); $j++, $index2++) {
                $node2 = $level2[$index2];
                $node2->parent_id = $node1->id;
                $node2->save();

                for ($k = 0; $k < $L1 && $index3 < count($level3); $k++, $index3++) {
                    $node3 = $level3[$index3];
                    $node3->parent_id = $node2->id;
                    $node3->save();
                }
            }
        }
    }
}
