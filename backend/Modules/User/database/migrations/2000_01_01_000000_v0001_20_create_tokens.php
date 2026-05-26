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
        Schema::create('tokens', function (Blueprint $table) {
            $table->id()->comment("TokenID");
            $table->string('token')->comment("token值");
            $table->dateTime('expires_at')->nullable()->comment("过期时间");
            $table->dateTime('last_used_at')->nullable()->comment("最后使用时间");
            $table->string('name')->nullable()->default(null)->comment("Token名称");
            $table->text('abilities')->nullable()->comment("能力");
            $table->integer('tokenable_id')->nullable()->default(null)->comment("Tokenable ID");
            $table->string('tokenable_type')->nullable()->default(null)->comment("Tokenable 类型");
            $table->timestamps();
            $table->softDeletes();
            $table->comment("Token");
        });
    }

    public function down()
    {
        Schema::drop('tokens');
    }
};
