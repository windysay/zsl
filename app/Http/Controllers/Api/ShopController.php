<?php

namespace App\Http\Controllers\Api;

use App\Facades\ShopRepository;
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
use Illuminate\Support\Facades\Validator;

/**
 * 商会管理控制器
 *
 * @package App\Http\Controllers\Backend
 */
class ShopController extends BaseController
{
    /** 商户加盟申请 登录后*/
    public function joinApply(){
        try{
            $request = Input::get();

            if(empty($request['shop_name'])){
                throw new \LogicException('企业名称不能为空！',1006);
            }
            if(empty($request['user_name'])){
                throw new \LogicException('联系人不能为空！',1006);
            }
            if(empty($request['user_mobile'])){
                throw new \LogicException('联系方式不能为空',1007);
            }
            if(empty($request['user_id'])){
                throw new \LogicException('用户ID不能为空',1008);
            }

            $request['ispartner'] = 1;
            unset($request['access_token']);

            if(ShopRepository::create($request)){
                $message = '申请成功,工作人员会尽快给您答复';
                /** 发送邮件通知管理员 */
            }else{
                throw new \LogicException('网络出错,请检查网络连接',302);
            }

        }catch (\LogicException $e){
            $json['message'] = $e->getMessage();
            $json['status_code'] = $e->getCode();
            $json['data'] = null;
            return $json;
        }
        $json['message'] = $message;
        $json['status_code'] = 200;
        $json['data'] = null;
        return $json;
    }

    /** 商户申请加入黄页 */
    public function yellowPageApply(){
        try{
            $rules = [
                'shop_name' => ['required'],
                'user_name' => ['required'],
                'user_mobile' => ['required'],
                'user_email' => ['email'],
                'shop_email' => ['email'],
                'shop_url' => ['active_url'],
            ];

            $validator = app('validator')->make(Input::get(), $rules);

            if ($validator->fails()) {
                throw new StoreResourceFailedException('申请失败.', $validator->errors());
            }
            $request = Input::get();
            $request['user_id'] = Auth::id();
            unset($request['access_token']);
            print_r($request);die;
            /** 用户注册 */
            $data = ShopRepository::create($request);
            if($data){
                /** 发送邮件通知管理员 */
            }
        }catch (\LogicException $e){
            $json['message'] = $e->getMessage();
            $json['status_code'] = $e->getCode();
            $json['data'] = null;
            return $json;
        }
        $json['message'] = '黄页申请成功';
        $json['status_code'] = 200;
        $json['data'] = $data;
        return $json;
    }

    public function getShopStore(){
        $json['message'] = '获取商号成功';
        $json['status_code'] = 200;
        $json['data'] = config('shop.shop_store');
        return $json;
    }

    public function getStopCat(){
        $json['message'] = '获取商会行业';
        $json['status_code'] = 200;
        $json['data'] = config('shop.shop_cat');
        return $json;
    }
}
