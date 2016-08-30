<?php

$api = app('Dingo\Api\Routing\Router');

$api->version('v1', ['namespace' => 'App\Http\Controllers\API','middleware' => 'api.auth'], function ($api) {
    $api->get('user', 'UserController@index');
    //个人信息
    $api->post('user/info', 'UserController@info');
    //退出登录
    $api->post('auth/logout', 'AuthController@logout');
    //加盟申请
    $api->post('shop/joinUnionApply', 'ShopController@joinUnionApply');
    //加入黄页申请
    $api->post('shop/yellowPageApply', 'ShopController@yellowPageApply');
    //供需申请
    $api->post('goods/create', 'GoodsController@create');
    //修改手机号码
    $api->post('auth/changeMobile','AuthController@changeMobile');
    //修改头像
    $api->post('user/changeAvatar','UserController@changeAvatar');
    //文件上传
    $api->post('user/uploadFile','UserController@uploadFile');
    //发布商圈微博
    $api->post('weibo/create','WeiboController@create');
    //评论商圈微博
    $api->post('weibo/comment/{id}','WeiboController@comment');
    //商圈微博点赞
    $api->get('weibo/like/{id}','WeiboController@like');
    //商圈微博分享
    $api->get('weibo/share/{id}','WeiboController@share');
});

/** 不需要身份验证 */
$api->version('v1', ['namespace' => 'App\Http\Controllers\API'], function ($api) {
    //登录
    $api->post('login', 'AuthController@login');
    //注册
    $api->post('signup', 'AuthController@signup');
    //修改/忘记密码
    $api->post('auth/changePassword', 'AuthController@changePassword');
    //发送短信验证码
    $api->post('sendCode', 'SmsController@sendCode');
    //获取黄页列表
    $api->post('shop/getYellowPage', 'ShopController@getYellowPage');
    //获取加盟商会列表
    $api->post('shop/getUnionShopList', 'ShopController@getUnionShopList');
    //获取成员企业列表
    $api->get('shop/getMemberShopList/{parent_id}', 'ShopController@getMemberShopList');
    //获取商会详情
    $api->get('shop/getShopDetail/{id}', 'ShopController@getShopDetail');
    //商会商号
    $api->get('shop/store', 'ShopController@getShopStore');
    //商会类型
    $api->get('shop/cat', 'ShopController@getStopCat');
    //供需列表
    $api->get('goods/getList/{type}', 'GoodsController@getList');
    //供需详情
    $api->get('goods/detail/{id}', 'GoodsController@detail');
    //获取商圈微博列表
    $api->get('weibo/getList/{id}','WeiboController@getList');
    //商圈微博详情
    $api->get('weibo/detail/{id}','WeiboController@detail');
});

