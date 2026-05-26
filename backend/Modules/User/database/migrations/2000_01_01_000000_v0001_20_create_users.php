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
        Schema::create('users', function (Blueprint $table) {
            $table->id()->comment("用户ID");
            $table->string('username', 191)->comment("用户名");
            $table->string('password')->comment("密码");
            $table->string('nickname')->nullable()->comment("昵称");
            $table->string('email', 191)->nullable()->comment("邮箱");
            $table->string('phone', 191)->nullable()->comment("手机号");
            $table->string('avatar', 1024)->nullable()->comment("头像");
            $table->string('status', 32)->comment("状态:正常(active),禁用(disabled)");
            $table->dateTime('last_login_at')->nullable()->comment("最后登录时间");
            $table->timestamps();
            $table->softDeletes();
            $table->unique(['username'], "idx_username");
            $table->index(['email'], "idx_email");
            $table->index(['phone'], "idx_phone");
            $table->comment("用户");
        });
    }

    public function down()
    {
        Schema::drop('users');
    }
};
