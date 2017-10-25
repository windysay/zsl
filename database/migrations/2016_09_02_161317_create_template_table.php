<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTemplateTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('template', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->string('name')->comment('模板名');
            $table->string('banner')->nullable()->comment('轮播图');
            $table->string('navigation')->nullable()->comment('导航');
            $table->string('menu')->nullable()->comment('底部菜单');
            $table->integer('isuse')->default(0)->comment('是否使用中');
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
        Schema::drop('template');
    }
}
