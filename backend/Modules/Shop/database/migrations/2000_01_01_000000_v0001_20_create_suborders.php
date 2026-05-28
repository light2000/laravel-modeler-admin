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
        Schema::create('suborders', function (Blueprint $table) {
            $table->id()->comment("子订单ID");
            $table->integer('order_id')->comment("订单ID");
            $table->integer('product_id')->comment("产品ID");
            $table->integer('quantity')->comment("数量");
            $table->decimal('price', 10, 2)->comment("单价");
            $table->decimal('subtotal', 10, 2)->comment("小计金额");
            $table->string('status', 32)->comment("子订单状态:待支付(pending),已支付(paid),已发货(shipped),已完成(completed),已取消(cancelled)");
            $table->string('remark')->nullable()->comment("备注");
            $table->timestamps();
            $table->softDeletes();
            $table->index(['order_id'], "idx_order_id");
            $table->index(['product_id'], "idx_product_id");
            $table->index(['status'], "idx_status");
            $table->comment("子订单");
        });
    }

    public function down()
    {
        Schema::drop('suborders');
    }
};
