<?php

$api = app('Dingo\Api\Routing\Router');

$api->version('v1', ['namespace' => 'App\Http\Controllers\API','middleware' => 'api.auth'], function ($api) {
    $api->get('users', 'UserController@index');
    $api->get('users/{id}', 'UserController@show');
});

/** 不需要身份验证 */
$api->version('v1', ['namespace' => 'App\Http\Controllers\API'], function ($api) {
    $api->post('login', 'AuthController@login');
    $api->post('signup', 'AuthController@signup');
    $api->post('sendCode', 'SmsController@sendCode');
});

