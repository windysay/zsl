<?php
/* 后台首页 */
Route::get('index/', [
    'as'   => 'backend.index.index',
    'uses' => 'IndexController@index',
]);
Route::get('/', [
    'as'   => 'backend.index.index',
    'uses' => 'IndexController@index',
]);

/* 商会管理模块 */
Route::get('shop/index', [
    'as'   => 'backend.shop.index',
    'uses' => 'ShopController@index',
]);
Route::get('shop/store', [
    'as'   => 'backend.shop.store',
    'uses' => 'ShopController@store',
]);
Route::resource('shop', 'ShopController');

/* 菜单管理模块 */
Route::get('menu/search', [
    'as'         => 'backend.menu.search',
    'uses'       => 'MenuController@search',
    'middleware' => ['search'],
]);
Route::resource('menu', 'MenuController');

/* 用户管理模块 */
Route::resource("user", 'UserController');

/* 角色管理模块 */
Route::get('role/permission/{id}', [
    'as'   => 'backend.role.permission',
    'uses' => 'RoleController@permission',
]);
Route::post('role/associatePermission', [
    'as'   => 'backend.role.associate.permission',
    'uses' => 'RoleController@associatePermission',
]);
Route::resource("role", 'RoleController');

/* 权限管理模块 */
Route::get('permission/associate/{id}', [
    'as'   => 'backend.permission.associate',
    'uses' => 'PermissionController@associate',
]);
Route::post('permission/associateMenus', [
    'as'   => 'backend.permission.associate.menus',
    'uses' => 'PermissionController@associateMenus',
]);
Route::post('permission/associateActions', [
    'as'   => 'backend.permission.associate.actions',
    'uses' => 'PermissionController@associateActions',
]);
Route::resource("permission", 'PermissionController');

/* 操作管理模块 */
Route::resource('action', 'ActionController');

/* 文件管理模块 */
Route::get('file', [
    'as'   => 'backend.file.index',
    'uses' => 'FileController@index',
]);
Route::post('file/upload', [
    'as'   => 'backend.file.upload',
    'uses' => 'FileController@upload',
]);
