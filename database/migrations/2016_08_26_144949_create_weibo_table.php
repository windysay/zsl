<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWeiboTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('weibo', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->integer('user_id')->unsigned();
            $table->integer('business_id')->unsigned()->comment('商圈id');
            $table->text('content')->nullable()->comment('文字');
            $table->text('images')->nullable()->comment('图片');
            $table->string('vioce')->nullable()->comment('语音');
            $table->integer('like')->default(0)->comment('点赞数');
            $table->integer('share')->default(0)->comment('转发数');
            $table->integer('comment')->default(0)->comment('评论数');
            $table->integer('report')->default(0)->comment('举报数');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('weibo');
    }
}
