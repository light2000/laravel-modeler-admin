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
        Schema::create('permissions', function (Blueprint $table) {
            $table->id()->comment("权限ID");
            $table->string('name', 191)->comment("权限标识");
            $table->string('guard_name', 191)->nullable()->comment("所属GUARD");
            $table->timestamps();
            $table->softDeletes();
            $table->unique(['guard_name', 'name'], "uniq_name_guard_name");
            $table->comment("权限");
        });
    }

    public function down()
    {
        Schema::drop('permissions');
    }
};
