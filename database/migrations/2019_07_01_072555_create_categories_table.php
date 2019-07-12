<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();
            $table->string('name')->default('')->comment('名称');
            $table->string('icon')->default('')->comment('图标链接');
            $table->integer('sort')->default(0)->comment('排序')->unsigned();
            $table->tinyInteger('status')->default(1)->comment('状态,1有效,0无效')->unsigned();
            $table->text('remark')->comment('备注')->nullable();
            $table->text('description')->comment('描述')->nullable();
            $table->integer('video_num')->comment('视频数量')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('categories');
    }
}
