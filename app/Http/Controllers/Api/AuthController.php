<?php

namespace App\Http\Controllers\Api;

use App\Facades\UserRepository;
use App\Http\Controllers\BaseController;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Response;
use App\Http\Controllers\Api\SmsController as Sms;

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
                $data = $user = User::where(['name'=>$request['name']])->first();
                /** 获取token */
//                $data['access_token'] = DB::table('oauth_sessions')->leftJoin('oauth_access_tokens','oauth_access_tokens.session_id','=','oauth_sessions.id')->where(['oauth_sessions.owner_id'=>$user->id])->orderBy('oauth_sessions.created_at','desc')->pluck('oauth_access_tokens.id');
//                $uri = $_SERVER['HTTP_HOST']."/oauth/access_token_php";
//                $ch  = curl_init();
//                curl_setopt($ch, CURLOPT_URL, $uri);
//                curl_setopt($ch, CURLOPT_POST, 1);
//                curl_setopt($ch, CURLOPT_HEADER, 0);
//                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
//                curl_setopt($ch, CURLOPT_POSTFIELDS, ['client_id'=>'zslapp','client_secret'=>'zslapp','username'=>$request['name'],'password'=>$request['password'],'grant_type'=>'password']);    //输出格式可以转为数组形式的json格式
//                $token = curl_exec($ch);
//                curl_close($ch);
//                $data['user']['access_token'] = $token;
            }else{
                throw new \LogicException('账号或者密码错误',200);
            }

        }catch (\LogicException $e){
            $json['message'] = $e->getMessage();
            $json['status_code'] = $e->getCode();
            $json['data'] = null;
            return Response::json($json);
        }
        $json['message'] = $message;
        $json['status_code'] = 200;
        $json['data'] = $data;
        return Response::json($json);
    }

    public function signup(){
        try{
            $mobile = trim(Input::get('mobile'));
            $code = Input::get('code');
            $type = Input::get('type');
            $password = trim(Input::get('password'));
            $verifyPassword = Input::get('verifyPassword');
            /** 校验验证码 */
            Sms::verifyCode($mobile, $code, $type);

            if($password!=$verifyPassword){
                throw new \LogicException('两次输入的密码不一致',1008);
            }
            /** 判断用户是否注册 */
            $user = User::where(['name'=>$mobile])->count();
            if($user>0){
                throw new \LogicException('该手机号码已注册',1009);
            }
            /** 用户注册 */
            $udata = [
                'name'=>$mobile,
                'email'=>'',
                'password'=>bcrypt($password),
                'is_super_admin'=>0,
            ];
            $data = UserRepository::create($udata);

        }catch (\LogicException $e){
            $json['message'] = $e->getMessage();
            $json['status_code'] = $e->getCode();
            $json['data'] = null;
            return Response::json($json);
        }
        $json['message'] = '注册成功';
        $json['status_code'] = 200;
        $json['data'] = $data;
        return Response::json($json);
    }
}
