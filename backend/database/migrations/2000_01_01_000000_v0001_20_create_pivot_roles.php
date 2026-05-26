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
        Schema::create('pivot_roles', function (Blueprint $table) {
            $table->id()->comment("角色多态关联ID");
            $table->integer('role_id')->comment("角色ID");
            $table->integer('model_id')->comment("多态ID");
            $table->string('model_type')->nullable()->default(null)->comment("多态类型");
            $table->comment("角色多态关联");
        });
    }

    public function down()
    {
        Schema::drop('pivot_roles');
    }
};
