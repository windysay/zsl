<?php

use Illuminate\Database\Seeder;

class ShopStoreTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {


        \DB::table('shop_store')->delete();

        \DB::table('shop_store')->insert([
            0 =>['store_name'=>'其他行业',],
            1 =>['store_name'=>'酒店行业',],
            2 =>['store_name'=>'电子行业',],
            3 =>['store_name'=>'照明行业',],
            4 =>['store_name'=>'服装行业',],
            5 =>['store_name'=>'皮具行业',],
            6 =>['store_name'=>'食品行业',],
            7 =>['store_name'=>'旅游行业',],
            8 =>['store_name'=>'交通行业',],
            9 =>['store_name'=>'饮食行业',],
            10 =>['store_name'=>'教育行业',],
            11 =>['store_name'=>'法律行业',],
            12 =>['store_name'=>'房地产行业',],
            13 =>['store_name'=>'美容美发',],
            14 =>['store_name'=>'化妆品行业',],
            15 =>['store_name'=>'金融行业',],
            16 =>['store_name'=>'茶酒保健品',],
            17 =>['store_name'=>'汽车行业',],
            18 =>['store_name'=>'保险行业',],
            19 =>['store_name'=>'家具行业',],
        ]);


    }
}
