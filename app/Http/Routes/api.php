<?php

$api = app('Dingo\Api\Routing\Router');

$api->version('v1', ['namespace' => 'App\Http\Controllers\API','middleware' => 'api.auth'], function ($api) {
    $api->get('user', 'UserController@index');
    $api->get('user/{id}', 'UserController@show');
    //加盟申请
    $api->post('shop/joinApply', 'ShopController@joinApply');
    //商会商号
    $api->get('shop/store', 'ShopController@getShopStore');
    //商会类型
    $api->get('shop/cat', 'ShopController@getStopCat');
    //加入黄页申请
    $api->post('shop/yellowPageApply', 'ShopController@yellowPageApply');
});

/** 不需要身份验证 */
$api->version('v1', ['namespace' => 'App\Http\Controllers\API'], function ($api) {
    $api->post('login', 'AuthController@login');
    $api->post('signup', 'AuthController@signup');
    $api->post('sendCode', 'SmsController@sendCode');
});

