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
        Schema::create('administrators', function (Blueprint $table) {
            $table->id()->comment("管理员ID");
            $table->string('status', 32)->comment("状态:正常(active),禁用(disabled)");
            $table->string('mailbox', 191)->comment("邮箱");
            $table->string('password')->comment("密码");
            $table->string('nickname')->comment("昵称");
            $table->string('avatar', 255)->nullable()->comment("头像");
            $table->timestamps();
            $table->softDeletes();
            $table->index(['status'], "idx_status");
            $table->unique(['mailbox'], "uniq_mailbox");
            $table->comment("管理员");
        });
    }

    public function down()
    {
        Schema::drop('administrators');
    }
};
