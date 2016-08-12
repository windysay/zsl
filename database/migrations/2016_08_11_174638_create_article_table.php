<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArticleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('article', function (Blueprint $table) {
            $table->increments('id')->comment('id');
            $table->string('title')->comment('标题');
            $table->string('logo')->nullable()->comment('logo');
            $table->integer('cat_id')->comment('栏目id');
            $table->string('url')->nullable()->comment('网页/视频链接');
            $table->string('content')->nullable()->comment('内容');
            $table->integer('ifpub')->default(1)->comment('是否发布');
            $table->string('type')->default('article')->comment('类型');  //article文章 url链接 video视频
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('article');
    }
}
