<?php

namespace App\Http\Controllers\Api;

use App\Facades\ShopRepository;
use App\Http\Controllers\BaseController;
use Dingo\Api\Exception\StoreResourceFailedException;
use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Mail;
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
    public function joinUnionApply(){
        try{
            $request = Input::get();
            $rules = [
                'shop_name' => ['required'],
                'user_name' => ['required'],
                'user_mobile' => ['required'],
                'user_id' => ['required'],
            ];

            $validator = app('validator')->make($request, $rules);

            if ($validator->fails()) {
                throw new StoreResourceFailedException('申请提交失败.', $validator->errors());
            }

            $request['ispartner'] = 1;
            unset($request['access_token']);

            if(ShopRepository::create($request)){
                $message = '申请已提交,工作人员会尽快给您答复';
                /** 发送邮件通知管理员 */
                $text = '管理员您好, 有新的商户加盟, 请尽快审核处理. 传送门>>'.url('/backend/shop');
                $title = '有新的客户加盟';
                Mail::send('emails.message', ['text' => $text], function ($email) use ($text, $title) {
                    $email->to(env('ADMIN_EMAIL'))->subject($title);
                });
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
                throw new StoreResourceFailedException('申请提交失败.', $validator->errors());
            }
            $request = Input::get();
            $request['user_id'] = Auth::id();
            unset($request['access_token']);
            /** 用户注册 */
            $data = ShopRepository::create($request);
            if($data){
                /** 发送邮件通知管理员 */
                $text = '管理员您好, 有新的黄页申请, 请尽快审核处理. 传送门>>'.url('/backend/shop');
                $title = '有新的黄页申请';
                Mail::send('emails.message', ['text' => $text], function ($email) use ($text, $title) {
                    $email->to(env('ADMIN_EMAIL'))->subject($title);
                });
            }
        }catch (\LogicException $e){
            $json['message'] = $e->getMessage();
            $json['status_code'] = $e->getCode();
            $json['data'] = null;
            return $json;
        }
        $json['message'] = '黄页申请提交成功';
        $json['status_code'] = 200;
        $json['data'] = $data;
        return $json;
    }

    /** 获取黄页列表 行业/地区/商号条件筛选 */
    public function getYellowPage(){
        $keyword = Input::get('keyword');
        $cat_id = Input::get('cat_id');
        $store_id = Input::get('store_id');
        $province = Input::get('province');
        $map['parent_id'] = 0;//不显示成员企业
        $map['ispass'] = 1;   //只显示已审核
        $map['status'] = 'active';
        if($cat_id) $map['cat_id'] = $cat_id;
        if($store_id) $map['store_id'] = $store_id;
        if($keyword) $map['shop_name'] = ['like', '%'.$keyword.'%'];
        if($province) $map['area'] = ['like', $province.'%'];
        //print_r(Input::get());die;
        $shopList = ShopRepository::paginateWhere($map, config('repository.page-limit'), ['id','shop_name','area','addr','shop_tel','shop_logo']);
        $json['message'] = '获取黄页列表成功';
        $json['status_code'] = 200;
        $json['data'] = $shopList;
        return $json;
    }

    /** 获取加盟商户列表 行业/地区/商号条件筛选 */
    public function getUnionShopList(){
        $keyword = Input::get('keyword');
        $cat_id = Input::get('cat_id');
        $store_id = Input::get('store_id');
        $province = Input::get('province');
        $map['ispartner'] = 1;  //联盟商会成员
        $map['parent_id'] = 0;  //不显示成员企业
        $map['ispass'] = 1;     //只显示已审核
        $map['status'] = 'active';
        if($cat_id) $map['cat_id'] = $cat_id;
        if($store_id) $map['store_id'] = $store_id;
        if($keyword) $map['shop_name'] = ['like', '%'.$keyword.'%'];
        if($province) $map['area'] = ['like', $province.'%'];
        //print_r($map);die;
        $shopList = ShopRepository::paginateWhere($map, config('repository.page-limit'), ['id','shop_name','area','addr','shop_tel','shop_logo']);
        $json['message'] = '获取加盟商户列表成功';
        $json['status_code'] = 200;
        $json['data'] = $shopList;
        return $json;
    }

    /** 获取成员企业列表 行业/地区/商号条件筛选 */
    public function getMemberShopList($parent_id){
        $map['parent_id'] = $parent_id; //显示成员企业
        $map['ispass'] = 1;             //只显示已审核
        $map['status'] = 'active';
        $shopList = ShopRepository::paginateWhere($map, config('repository.page-limit'), ['id','shop_name','area','addr','shop_tel','shop_logo']);
        $json['message'] = '获取成员企业列表成功';
        $json['status_code'] = 200;
        $json['data'] = $shopList;
        return $json;
    }

    /** 获取商会成员 */
    public function getShopDetail($id){
        $data = ShopRepository::find($id, ['shop_name','shop_descript','area','addr','shop_tel','shop_logo','shop_email','shop_url','lng','lat','shop_qrcode']);
        if($data){
            $json['message'] = '获取商会详情成功';
            $json['status_code'] = 200;
            $json['data'] = $data;
            return $json;
        }else{
            $json['message'] = '不存在该商会';
            $json['status_code'] = 400;
            $json['data'] = null;
            return $json;
        }
    }

    public function getShopStore(){
        $json['message'] = '获取商号成功';
        $json['status_code'] = 200;
        $json['data'] = config('shop.shop_store');
        return $json;
    }

    public function getStopCat(){
        $json['message'] = '获取商会行业成功';
        $json['status_code'] = 200;
        $json['data'] = config('shop.shop_cat');
        return $json;
    }

    public function getProvince(){
        $json['message'] = '获取商会省份成功';
        $json['status_code'] = 200;
        $json['data'] = config('shop.province');
        return $json;
    }
}
