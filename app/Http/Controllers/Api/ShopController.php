<?php

namespace App\Http\Controllers\Api;

use App\Facades\ShopRepository;
use App\Http\Controllers\BaseController;
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
    public function joinUnionApply(){
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
                $message = '已提交申请,工作人员会尽快给您答复';
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
                throw new StoreResourceFailedException('申请提交失败.', $validator->errors());
            }
            $request = Input::get();
            $request['user_id'] = Auth::id();
            unset($request['access_token']);
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
        $area_code = Input::get('area_code');
        $map['parent_id'] = 0;//不显示成员企业
        $map['ispass'] = 1;   //只显示已审核
        if($cat_id) $map['cat_id'] = $cat_id;
        if($store_id) $map['store_id'] = $store_id;
        if($keyword) $map['shop_name'] = ['like', '%'.$keyword.'%'];
        //print_r(Input::get());die;
        /** 地区筛选暂时先放着,后面补全 */
        $shopList = ShopRepository::paginateWhere($map, config('repository.page-limit'), ['id','shop_name','addr_code','addr','shop_tel','shop_logo']);
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
        $area_code = Input::get('area_code');
        $map['ispartner'] = 1;  //联盟商会成员
        $map['parent_id'] = 0;  //不显示成员企业
        $map['ispass'] = 1;     //只显示已审核
        if($cat_id) $map['cat_id'] = $cat_id;
        if($store_id) $map['store_id'] = $store_id;
        if($keyword) $map['shop_name'] = ['like', '%'.$keyword.'%'];
        //print_r($map);die;
        /** 地区筛选暂时先放着,后面补全 */
        $shopList = ShopRepository::paginateWhere($map, config('repository.page-limit'), ['id','shop_name','addr_code','addr','shop_tel','shop_logo']);
        $json['message'] = '获取加盟商户列表成功';
        $json['status_code'] = 200;
        $json['data'] = $shopList;
        return $json;
    }

    /** 获取成员企业列表 行业/地区/商号条件筛选 */
    public function getMemberShopList(){
        $parent_id = Input::get('parent_id');
        $map['parent_id'] = $parent_id; //显示成员企业
        $map['ispass'] = 1;             //只显示已审核
        $shopList = ShopRepository::paginateWhere($map, config('repository.page-limit'), ['id','shop_name','addr_code','addr','shop_tel','shop_logo']);
        $json['message'] = '获取成员企业列表成功';
        $json['status_code'] = 200;
        $json['data'] = $shopList;
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
