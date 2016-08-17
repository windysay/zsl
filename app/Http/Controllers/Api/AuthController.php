<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\BaseController;
use App\Models\User;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Response;
use LucaDegasperi\OAuth2Server\Facades\Authorizer;

/**
 * 用户登录注册管理控制器
 *
 * @package App\Http\Controllers\Backend
 */
class AuthController extends BaseController
{
    public function login(){
        try{
            $request = Input::get();
            if(empty($request['name'])){
                throw new \LogicException('登陆用户名不能为空！',1006);
            }

            if(empty($request['password'])){
                throw new \LogicException('登陆密码不能为空',1007);
            }

            if(Auth::attempt(['name'=>$request['name'],'password'=>$request['password']], true)){
                $message = '登录成功';
                /** 获取用户资料 */
                $data['user'] = $user = User::where(['name'=>$request['name']])->first();
                /** 获取token */
                $data['access_token'] = DB::table('oauth_sessions')->leftJoin('oauth_access_tokens','oauth_access_tokens.session_id','=','oauth_sessions.id')->where(['oauth_sessions.owner_id'=>$user->id])->pluck('oauth_access_tokens.id');
            }else{
                throw new \LogicException('账号或者密码错误',200);
            }

        }catch (\LogicException $e){
            $json['message'] = $e->getMessage();
            $json['status_code'] = $e->getCode();
            $json['data'] = null;
            return $json;
        }
        $json['message'] = $message;
        $json['status_code'] = 200;
        $json['data'] = $data;
        return $json;

    }
}
