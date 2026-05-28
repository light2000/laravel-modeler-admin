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
        Schema::create('categories', function (Blueprint $table) {
            $table->id()->comment("分类ID");
            $table->string('name', 191)->comment("分类名称");
            $table->integer('parent_id')->nullable()->comment("父分类");
            $table->integer('sort_order')->comment("排序");
            $table->string('icon', 1024)->nullable()->comment("图标");
            $table->timestamps();
            $table->softDeletes();
            $table->unique(['name'], "idx_name");
            $table->index(['parent_id'], "idx_parent_id");
            $table->comment("分类");
        });
    }

    public function down()
    {
        Schema::drop('categories');
    }
};
