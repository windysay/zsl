<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\BaseController;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Response;

/**
 * 短信管理控制器
 *
 * @package App\Http\Controllers\Backend
 */
class SmsController extends BaseController
{
    /**
     * 发送短信验证码
     * type 类型形式(注册[signup]、找回密码[forgot]、重置手机号[reset])
     * @return mixed
     */
    public function sendCode(){
        try{
            $mobile = Input::get('mobile');
            $type = Input::get('type');
            if(empty($mobile)){
                throw new \LogicException('手机号码不能为空',1005);
            }
            if(!preg_match("/^1[34578]{1}[0-9]{9}$/",$mobile)){
                throw new \LogicException('手机号码不正确',1006);
            }
            /**
             * 模拟短信发送, 后面接入Laravel SMS
             * https://github.com/toplan/laravel-sms
             */
            $redis = Redis::connection('default');
            $key = $type.'code'.$mobile; //格式: signupcode13794311355
            $code = $redis->get($key);
            if(!$code){
                $code = rand(100000,999999);
                $redis->setex($key, 5*60, $code); //缓存周期5min
            }
            $data['mobile'] = $mobile;
            $data['code'] = $code;
        }catch (\LogicException $e){
            $json['message'] = $e->getMessage();
            $json['status_code'] = $e->getCode();
            $json['data'] = null;
            return Response::json($json);
        }
        $json['message'] = '获取短信验证码成功';
        $json['status_code'] = 200;
        $json['data'] = $data;
        return Response::json($json);
    }

    public static function verifyCode($mobile, $code, $type){
        $redis = Redis::connection('default');
        $key = $type.'code'.$mobile; //格式: signupcode13794311355
        $verifyCode = $redis->get($key);
        if(!$verifyCode){
            throw new \LogicException('验证码已过期',1007);
        }
        if($code!=$verifyCode) {
            throw new \LogicException('验证码不正确', 1009);
        }
        return true;
    }
}
