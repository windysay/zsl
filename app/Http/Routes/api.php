<?php

$api = app('Dingo\Api\Routing\Router');

$api->version('v1', ['namespace' => 'App\Http\Controllers\API','middleware' => 'api.auth'], function ($api) {
    $api->get('user', 'UserController@index');
    $api->get('user/{id}', 'UserController@show');
    //加盟申请
    $api->post('shop/joinUnionApply', 'ShopController@joinUnionApply');
    //加入黄页申请
    $api->post('shop/yellowPageApply', 'ShopController@yellowPageApply');
    //供需申请
    $api->post('goods/create', 'GoodsController@create');
});

/** 不需要身份验证 */
$api->version('v1', ['namespace' => 'App\Http\Controllers\API'], function ($api) {
    $api->post('login', 'AuthController@login');
    $api->post('signup', 'AuthController@signup');
    $api->post('sendCode', 'SmsController@sendCode');
    //获取黄页列表
    $api->post('shop/getYellowPage', 'ShopController@getYellowPage');
    //获取加盟商会列表
    $api->post('shop/getUnionShopList', 'ShopController@getUnionShopList');
    //获取成员企业列表
    $api->post('shop/getMemberShopList', 'ShopController@getMemberShopList');
    //获取商会详情
    $api->post('shop/getShopDetail', 'ShopController@getShopDetail');
    //商会商号
    $api->get('shop/store', 'ShopController@getShopStore');
    //商会类型
    $api->get('shop/cat', 'ShopController@getStopCat');
    //供需列表
    $api->get('goods/getList', 'GoodsController@getList');
    //供需详情
    $api->get('goods/detail', 'GoodsController@detail');
});

