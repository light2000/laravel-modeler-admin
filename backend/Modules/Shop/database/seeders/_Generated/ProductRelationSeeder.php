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

use Modules\Shop\Models\Product;
use Illuminate\Database\Seeder;
use Modules\Shop\Models\Category;
use Modules\Shop\Models\Athlete;
use Modules\Shop\Models\Actor;
use Illuminate\Support\Facades\Log;

class ProductRelationSeeder extends Seeder
{
    public function run(): void
    {
        $productList = Product::orderBy('id')->get();
        $totalCount = count($productList);
        $categoryListIds = collect(Category::pluck('id'))->shuffle()->toArray();
        $categoryCount = count($categoryListIds);
        $productList->each(function ($product, $index) use ($categoryListIds, $categoryCount) {
            try {
                $product->update([
                    'category_id' => $categoryListIds[$index%$categoryCount],
                ]);
            } catch (\Exception $e) {
                Log::info("update product category_id failed: " . $e->getMessage());
            }
        });
        $athleteList = Athlete::all()->shuffle();
        $athleteList = Athlete::all()->shuffle();
        $actorList = Actor::all()->shuffle();
        $indexes = [];
        $indexes['athlete'] = 0;
        $indexes['athlete'] = 0;
        $indexes['actor'] = 0;
        foreach ($productList as $index => $product) {
            if ($index % 3 == 0) {
                try {
                    $product->spokesperson()->associate($athleteList[($indexes['athlete']++) % count($athleteList)]);
                    $product->save();
                } catch (\Exception $e) {
                    Log::info("update product spokesperson associate failed: " . $e->getMessage());
                }
                continue;
            }
            if ($index % 3 == 1) {
                try {
                    $product->spokesperson()->associate($athleteList[($indexes['athlete']++) % count($athleteList)]);
                    $product->save();
                } catch (\Exception $e) {
                    Log::info("update product spokesperson associate failed: " . $e->getMessage());
                }
                continue;
            }
            if ($index % 3 == 2) {
                try {
                    $product->spokesperson()->associate($actorList[($indexes['actor']++) % count($actorList)]);
                    $product->save();
                } catch (\Exception $e) {
                    Log::info("update product spokesperson associate failed: " . $e->getMessage());
                }
                continue;
            }
        }
    }
}
