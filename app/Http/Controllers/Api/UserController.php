<?php

namespace App\Http\Controllers\Api;

use App\Facades\UserRepository;
use App\Http\Controllers\BaseController;
use Illuminate\Http\Request;
use App\Http\Requests;

/**
 * 用户管理控制器
 *
 * @package App\Http\Controllers\Backend
 */
class UserController extends BaseController
{
    public function index()
    {
        $data = UserRepository::paginate(10);

        $json['message'] = '用户列表';
        $json['status_code'] = 200;
        $json['data'] = $data;
        return $json;
    }

    public function show()
    {
        $data = UserRepository::find(Input::get('id'));

        $json['message'] = '我的个人资料';
        $json['status_code'] = 200;
        $json['data'] = $data;
        return $json;
    }

}
