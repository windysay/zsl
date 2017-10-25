<?php

/* 后台登录模块 */
Route::group(['namespace' => 'Auth'], function () {
    require_once __DIR__ . '/Routes/auth.php';
});

/* 前端管理模块 */
Route::group(['namespace' => 'Frontend'], function () {
    require_once __DIR__ . '/Routes/frontend.php';
});

/* 后台管理模块 */
Route::group([
    'prefix'     => 'backend',
    'namespace'  => 'Backend',
    'middleware' => ['authenticate', 'authorize'],
], function () {
    require_once __DIR__ . '/Routes/backend.php';
});

/* API 接口管理模块 */
Route::group([
    'prefix'     => 'api',
    'namespace'  => 'API',
], function () {
    require_once __DIR__ . '/Routes/api.php';
});

//获取API access_token
Route::post('oauth/access_token', function() {
    $name = Input::get('username');
    $redis = Redis::connection('default');
    $access_token = $redis->get('oauthAccessToken'.$name);  //格式: oauthAccessToken13794311355
    if(!$access_token){  //重新获取accessToken写到缓存
        $access_token = Authorizer::issueAccessToken()['access_token'];
        $redis->setex('oauthAccessToken'.$name, 7*24*3600,$access_token); //设置7天过期时间
    }
    $data['access_token'] = $access_token;
    $json['message'] = '获取AccessToken成功';
    $json['status_code'] = 200;
    $json['data'] = $data;
    return Response::json($json);
});

