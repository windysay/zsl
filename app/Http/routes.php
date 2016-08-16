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
    return Response::json(Authorizer::issueAccessToken());
});

