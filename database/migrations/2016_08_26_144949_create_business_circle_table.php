<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBusinessCircleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('business_circle', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->string('name')->nullable()->comment('商圈名');
            $table->string('introduct')->nullable()->comment('简介');
            $table->string('logo')->nullable()->comment('logo');
            $table->integer('number')->default(0)->comment('人数');
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
        Schema::drop('business_circle');
    }
}
