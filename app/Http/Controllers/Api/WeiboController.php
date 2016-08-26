<?php

namespace App\Http\Controllers\Api;

use App\Facades\WeiboRepository;
use App\Http\Controllers\BaseController;
use Dingo\Api\Exception\StoreResourceFailedException;
use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;

/**
 * 微博发布管理控制器
 *
 * @package App\Http\Controllers\Backend
 */
class WeiboController extends BaseController
{
    public function create(){
        try{
            $request = Input::get();
            $rules = [
                'business_id' => ['required'],
            ];

            $validator = app('validator')->make($request, $rules);

            if ($validator->fails()) {
                throw new StoreResourceFailedException('发布失败.', $validator->errors());
            }
            $request['user_id'] = Auth::id();
            unset($request['access_token']);
            //print_r($request);die;
            WeiboRepository::create($request);
        }catch (\LogicException $e){
            $json['message'] = $e->getMessage();
            $json['status_code'] = $e->getCode();
            $json['data'] = null;
            return $json;
        }
        $json['message'] = '微博发布成功';
        $json['status_code'] = 200;
        $json['data'] = null;
        return $json;
    }

    /** 获取微博列表
     *
     *  return json
     */
    public function getList($id)
    {
        try{
            $data = WeiboRepository::paginateWhere(['business_id'=>$id], config('repository.page-limit'));
        }catch(\LogicException $e){
            $json['message'] = $e->getMessage();
            $json['status_code'] = $e->getCode();
            $json['data'] = null;
            return $json;
        }
        $json['message'] = '获取微博列表成功';
        $json['status_code'] = 200;
        $json['data'] = $data;
        return $json;
    }

    public function detail($id)
    {
        try{
            $data = WeiboRepository::find($id);
            /** 获取评论列表 */

        }catch(\LogicException $e){
            $json['message'] = $e->getMessage();
            $json['status_code'] = $e->getCode();
            $json['data'] = null;
            return $json;
        }
        $json['message'] = '微博详情获取成功';
        $json['status_code'] = 200;
        $json['data'] = $data;
        return $json;
    }

    /** 评论微博
     *
     *  return json
     */
    public function comment($id){
        try{
            //$requset->only(['id','content']);

        }catch(\LogicException $e){
            $json['message'] = '评论保存失败';
            $json['status_code'] = $e->getCode();
            $json['data'] = null;
            return $json;
        }
        $json['message'] = '评论成功';
        $json['status_code'] = 200;
        $json['data'] = null;
        return $json;
    }
    /** 微博点赞
     *
     *  return json
     */
    public function like($id){
        try{
            $data = WeiboRepository::find($id);
            WeiboRepository::saveById($id,['like'=>$data->like+1]);
        }catch(\LogicException $e){
            $json['message'] = '点赞保存失败';
            $json['status_code'] = $e->getCode();
            $json['data'] = null;
            return $json;
        }
        $json['message'] = '点赞成功';
        $json['status_code'] = 200;
        $json['data'] = $data->like+1;
        return $json;
    }
    /** 微博分享
     *
     *  return json
     */
    public function share($id){
        try{
            $data = WeiboRepository::find($id);
            WeiboRepository::saveById($id,['share'=>$data->share+1]);
        }catch(\LogicException $e){
            $json['message'] = '分享保存失败';
            $json['status_code'] = $e->getCode();
            $json['data'] = null;
            return $json;
        }
        $json['message'] = '分享成功';
        $json['status_code'] = 200;
        $json['data'] = $data->share+1;
        return $json;
    }

}
