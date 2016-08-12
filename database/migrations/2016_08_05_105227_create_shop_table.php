<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateShopTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shop', function (Blueprint $table) {
            $table->increments('id')->comment('id');
            $table->integer('user_id')->unsigned()->comment('申请用户id');
            $table->integer('cat_id')->unsigned()->comment('行业id');
            $table->integer('store_id')->unsigned()->comment('商号id');
            $table->string('shop_name')->comment('商会名');
            $table->longText('shop_descript')->comment('描述');
            $table->string('parent_id')->comment('父类商会id');
            $table->string('status')->default('unactive')->comment('商会状态');  //active已激活状态
            $table->string('shop_logo')->comment('商标');
            $table->string('shop_banner')->comment('商会banner');
            $table->string('shop_tel')->comment('客服电话');
            $table->string('shop_email')->comment('商会邮箱');
            $table->string('addr_code')->comment('地区id');
            $table->string('addr')->comment('具体地址');
            $table->string('shop_url')->comment('官网链接');
            $table->string('shop_qrcode')->comment('二维码');
            $table->string('lng')->comment('经度');
            $table->string('lat')->comment('纬度');
            //联系人信息(用于审核结果通知)
            $table->string('user_name')->comment('联系人名字');
            $table->string('user_mobile')->comment('联系人电话');
            $table->string('user_email')->comment('联系人邮箱');
            $table->timestamps();
            //外键约束
            //$table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('shop', function (Blueprint $table) {
            $table->dropForeign('shop_user_id_foreign');
        });
        Schema::drop('shop');
    }
}
