<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVideosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('videos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();
            $table->string('name')->default('')->comment('名称');
            $table->string('icon')->default('')->comment('图标');
            $table->integer('category_id')->comment('分类id');
            $table->integer('subject_id')->comment('主题id');
            $table->string('mainimg')->default('')->comment('主图');
            $table->string('original_m3u8')->default('')->comment('原m3u8文件');
            $table->string('m3u8')->default('')->comment('m3u8文件');
            $table->string('original_mp4')->comment('原mp4文件')->default('');
            $table->string('mp4')->comment('MP4文件')->default('');
            $table->integer('long')->comment('时长,秒数')->default(0);
            $table->integer('see_num')->comment('观看次数')->default(0);
            $table->string('tag_ids')->comment('标签id')->default('');
            $table->tinyInteger('need_charge')->comment('是否需要充值,1.需要，0.不需要')->default(0);
            $table->tinyInteger('status')->comment('状态,0无效，1有效')->default(1);
            $table->tinyInteger('long_type')->comment('视频时长类型')->default(1)->unsigned();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('videos');
    }
}
