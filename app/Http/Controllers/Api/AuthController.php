<?php

namespace App\Http\Controllers\Api;

use App\Facades\UserRepository;
use App\Http\Controllers\BaseController;
use App\Models\User;
use Dingo\Api\Exception\StoreResourceFailedException;
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
    /**
     * 登录 手动认证用户
     * @return mixed
     */
    public function login(){
        try{
            $request = Input::get();
            $rules = [
                'name' => ['required'],
                'password' => ['required'],
            ];

            $validator = app('validator')->make($request, $rules);

            if ($validator->fails()) {
                throw new StoreResourceFailedException('提交失败.', $validator->errors());
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
            return $json;
        }
        $json['message'] = $message;
        $json['status_code'] = 200;
        $json['data'] = $data;
        return $json;
    }

    /**
     * 注册
     * type 类型形式(注册[signup]、找回密码[forgot]、重置手机号[reset])
     * @return mixed
     */
    public function signup(){
        try{
            $mobile = trim(Input::get('name'));
            $code = Input::get('code');
            $type = 'signup';
            $password = trim(Input::get('password'));

            /** 校验验证码 */
            Sms::verifyCode($mobile, $code, $type);

            $rules = [
                'name' => ['required','unique:users'],
                'code' => ['required'],
                //confirmed 必须和输入数据里的 password_confirmation 的值保持一致。
                'password' => ['required','min:6','confirmed'],
                'password_confirmation' => ['required','min:6'],
            ];

            $validator = app('validator')->make(Input::get(), $rules);

            if ($validator->fails()) {
                throw new StoreResourceFailedException('提交失败.', $validator->errors());
            }

            if(!preg_match("/^1[34578]{1}[0-9]{9}$/",$mobile)){
                throw new \LogicException('手机号码不正确',1006);
            }

            /** 用户注册 */
            $udata = [
                'name'=>$mobile,
                'email'=>'',
                'password'=>bcrypt($password),
                'is_super_admin'=>0,
            ];
            $data = UserRepository::create($udata);

            if($data) {
                //登录
                Auth::attempt(['name'=>$mobile,'password'=>$password], true);
            }

        }catch (\LogicException $e){
            $json['message'] = $e->getMessage();
            $json['status_code'] = $e->getCode();
            $json['data'] = null;
            return $json;
        }
        $json['message'] = '注册并登录成功';
        $json['status_code'] = 200;
        $json['data'] = $data;
        return $json;
    }

    /**
     * 修改手机号码 需要先发送短信验证码
     * type 类型形式(注册[signup]、找回密码[forgot]、重置手机号[reset])
     * @return mixed
     */
    public function changeMobile(){
        try{
            $mobile = trim(Input::get('name'));
            $code = Input::get('code');
            $type = 'reset';

            $rules = [
                'name' => ['required'],
                'code' => ['required'],
                //'password' => ['required','min:6'],
            ];

            $validator = app('validator')->make(Input::get(), $rules);

            if ($validator->fails()) {
                throw new StoreResourceFailedException('提交失败.', $validator->errors());
            }

            if(!preg_match("/^1[34578]{1}[0-9]{9}$/",$mobile)){
                throw new \LogicException('手机号码不正确',1006);
            }

            /** 校验验证码 */
            Sms::verifyCode($mobile, $code, $type);

            UserRepository::saveById(Auth::id(), ['name'=>$mobile]);

        }catch (\LogicException $e){
            $json['message'] = $e->getMessage();
            $json['status_code'] = $e->getCode();
            $json['data'] = null;
            return $json;
        }
        $json['message'] = '手机号码修改成功';
        $json['status_code'] = 200;
        $json['data'] = null;
        return $json;

    }
}
