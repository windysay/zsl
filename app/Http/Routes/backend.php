<?php
/* 本地化切换 */
Route::get('language/{locale}', function ($locale) {
    App::setLocale($locale);

    return redirect()->route('backend.index.index');
});

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
Route::post('shop/pass', [
    'as'   => 'backend.shop.pass',
    'uses' => 'ShopController@pass',
]);
Route::resource('shop', 'ShopController');

/* 菜单管理模块 */
Route::get('menu/search', [
    'as'         => 'backend.menu.search',
    'uses'       => 'MenuController@search',
    'middleware' => ['search'],
]);
Route::resource('menu', 'MenuController');

/* 文章栏目管理模块 */
Route::resource('articlecat', 'ArticleCatController');
/* 文章栏目管理 */
Route::resource('article', 'ArticleController');

/* 用户管理模块 */
Route::resource("user", 'UserController');
Route::get('user/profile/{id}', [
    'as'   => 'backend.user.profile',
    'uses' => 'UserController@profile',
]);
Route::post('user/update-profile', [
    'as'   => 'backend.user.update-profile',
    'uses' => 'UserController@updateProfile',
]);

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

/* 发送测试文字邮件 */
Route::get('email/send/{id}', [
    'as'   => 'backend.email.send',
    'uses' => 'EmailController@send',
]);

/* 发送测试图文邮件 */
Route::get('email/sendPicture/{id}', [
    'as'   => 'backend.email.sendPicture',
    'uses' => 'EmailController@sendPicture',
]);

/* 发送测试附件邮件 */
Route::get('email/sendFile/{id}', [
    'as'   => 'backend.email.sendFile',
    'uses' => 'EmailController@sendFile',
]);