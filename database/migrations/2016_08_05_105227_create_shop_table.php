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
            $table->tinyInteger('ispass')->default(0)->comment('是否通过审核');
            $table->tinyInteger('ispartner')->default(0)->comment('是否加盟商户');
            $table->string('shop_name')->comment('商会名');
            $table->longText('shop_descript')->nullable()->comment('描述');
            $table->integer('parent_id')->nullable()->comment('父类商会id');
            $table->string('status')->default('unactive')->comment('商会状态');  //active已激活状态
            $table->string('shop_logo')->nullable()->comment('商标');
            $table->string('shop_banner')->nullable()->comment('商会banner');
            $table->string('shop_tel')->nullable()->comment('客服电话');
            $table->string('shop_email')->nullable()->comment('商会邮箱');
            $table->string('area')->nullable()->comment('省市区');
            $table->string('addr')->nullable()->comment('具体地址');
            $table->string('shop_url')->nullable()->comment('官网链接');
            $table->string('shop_qrcode')->nullable()->comment('二维码');
            $table->string('lng')->nullable()->comment('经度');
            $table->string('lat')->nullable()->comment('纬度');
            //联系人信息(用于审核结果通知)
            $table->string('user_name')->nullable()->comment('联系人名字');
            $table->string('user_mobile')->nullable()->comment('联系人电话');
            $table->string('user_email')->nullable()->comment('联系人邮箱');
            $table->string('user_addr')->nullable()->comment('联系人地址');
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
