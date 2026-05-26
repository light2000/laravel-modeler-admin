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
        Schema::create('roles', function (Blueprint $table) {
            $table->id()->comment("角色ID");
            $table->string('name', 191)->comment("角色名称");
            $table->string('guard_name')->nullable()->comment("角色GUARD");
            $table->timestamps();
            $table->softDeletes();
            $table->unique(['name'], "idx_name");
            $table->comment("角色");
        });
    }

    public function down()
    {
        Schema::drop('roles');
    }
};
