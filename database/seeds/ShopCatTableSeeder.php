<?php

use Illuminate\Database\Seeder;

class ShopCatTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {


        \DB::table('shop_cat')->delete();

        \DB::table('shop_cat')->insert([
            0 =>['cat_name'=>'其他'],
            1 =>['cat_name'=>'粤商'],
            2 =>['cat_name'=>'豫商'],
        ]);


    }
}
