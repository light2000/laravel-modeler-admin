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
        Schema::create('orders', function (Blueprint $table) {
            $table->id()->comment("订单ID");
            $table->integer('user_id')->nullable()->comment("用户ID");
            $table->string('order_no', 191)->comment("订单编号");
            $table->decimal('total_amount', 10, 2)->comment("订单总金额");
            $table->string('status', 32)->comment("订单状态:待支付(pending),已支付(paid),已发货(shipped),已完成(completed),已取消(cancelled)");
            $table->timestamps();
            $table->softDeletes();
            $table->unique(['user_id'], "idx_user_id");
            $table->unique(['order_no'], "idx_order_no");
            $table->index(['status'], "idx_status");
            $table->comment("订单");
        });
    }

    public function down()
    {
        Schema::drop('orders');
    }
};
