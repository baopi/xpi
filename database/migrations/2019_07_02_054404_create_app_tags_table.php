<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAppTagsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('app_tags', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();
            $table->integer('app_id')->comment('应用id');
            $table->integer('tag_id')->comment('标签id');
            $table->tinyInteger('status')->comment('状态，1有效，0无效')->default(1);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('app_tags');
    }
}
