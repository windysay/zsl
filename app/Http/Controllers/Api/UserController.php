<?php

namespace App\Http\Controllers\Api;

use App\Facades\UserRepository;
use App\Http\Controllers\BaseController;
use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;

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

    public function info()
    {
        $data = UserRepository::find(Auth::id());

        $json['message'] = '我的个人资料';
        $json['status_code'] = 200;
        $json['data'] = $data;
        return $json;
    }

    public function changeAvatar(){
        try{
            $imgUrl = Input::get('imgUrl');
            UserRepository::saveById(Auth::id(), ['avatar'=>$imgUrl]);
        }catch (\LogicException $e){
            $json['message'] = $e->getMessage();
            $json['status_code'] = 400;
            $json['data'] = null;
            return $json;
        }
        $json['message'] = '头像修改成功';
        $json['status_code'] = 200;
        $json['data'] = $imgUrl;
        return $json;
    }

}
