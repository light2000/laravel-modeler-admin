<?php
/*
|--------------------------------------------------------------------------
|  ⚠️ 提示 ⚠️
|--------------------------------------------------------------------------
| 此文件由laravel-modeler自动生成，请勿直接手动修改。
| 如需调整，请在laravel-modeler修改/设计后重新生成。
|--------------------------------------------------------------------------
*/
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id()->comment("产品ID");
            $table->string('name', 1)->comment("产品名称");
            $table->text('description')->nullable()->comment("产品描述");
            $table->decimal('price', 10, 2)->comment("价格");
            $table->integer('stock')->comment("库存");
            $table->integer('category_id')->comment("分类ID");
            $table->string('status', 32)->comment("产品状态:上架(on_sale),下架(off_sale)");
            $table->json('photos')->nullable()->comment("组图");
            $table->json('label')->nullable()->comment("标签");
            $table->string('cover_image', 255)->nullable()->comment("封面图");
            $table->boolean('free_shipping')->default(false)->comment("包邮");
            $table->mediumText('detailed_information')->nullable()->comment("详细信息");
            $table->dateTime('on_sale_time')->default(null)->nullable()->comment("上架时间");
            $table->date('production_date')->nullable()->default(null)->comment("生产日期");
            $table->integer('spokesperson_id')->nullable()->default(null)->comment("代言人");
            $table->string('spokesperson_type')->nullable()->default(null)->comment("代言人类型");
            $table->timestamps();
            $table->softDeletes();
            $table->index(['category_id'], "idx_category_id");
            $table->comment("产品");
        });
    }

    public function down()
    {
        Schema::drop('products');
    }
};
