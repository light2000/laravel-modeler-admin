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
        Schema::create('athletes', function (Blueprint $table) {
            $table->id()->comment("运动员ID");
            $table->string('name')->comment("姓名");
            $table->string('gender', 32)->nullable()->comment("性别:男(male),女(female)");
            $table->decimal('height', 8, 3)->nullable()->comment("身高");
            $table->decimal('weight', 8, 3)->nullable()->comment("体重");
            $table->date('birthday')->nullable()->comment("出生日期");
            $table->string('avatar', 1024)->nullable()->comment("头像");
            $table->timestamps();
            $table->softDeletes();
            $table->comment("运动员");
        });
    }

    public function down()
    {
        Schema::drop('athletes');
    }
};
