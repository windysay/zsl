<?php

namespace App\Http\Controllers\Api;

use App\Facades\GoodsRepository;
use App\Http\Controllers\BaseController;
use Dingo\Api\Exception\StoreResourceFailedException;
use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Mail;

/**
 * 供需发布管理控制器
 *
 * @package App\Http\Controllers\Backend
 */
class GoodsController extends BaseController
{
    public function create(){
        try{
            $request = Input::get();
            $rules = [
                'title' => ['required'],
                'introduct' => ['required'],
                'user_name' => ['required'],
                'images' => ['required'],
                'type' => ['required'],
                'user_email' => ['email'],
                'user_mobile' => ['required'],
            ];

            $validator = app('validator')->make($request, $rules);

            if ($validator->fails()) {
                throw new StoreResourceFailedException('申请提交失败.', $validator->errors());
            }
            $request['user_id'] = Auth::id();
            unset($request['access_token']);
            //print_r($request);die;
            if(GoodsRepository::create($request)){
                $message = '申请已提交,工作人员会尽快给您审核';
                /** 发送邮件通知管理员 */
                $text = '管理员您好, 有新的供需发布信息, 请尽快审核处理. 传送门>>'.url('/backend/goods');
                $title = '有新的供需发布信息';
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

    /** 获取供需列表
     *  type [空]全部 [give]供应 [need]需求
     *  return json
     */
    public function getList()
    {
        $type = Input::get('type');
        if($type){
            $map['type'] = $type;
        }
        $map['ispass'] = 1; //审核通过
        $data = GoodsRepository::paginateWhere($map, config('repository.page-limit'));

        $json['message'] = '获取供需列表成功';
        $json['status_code'] = 200;
        $json['data'] = $data;
        return $json;
    }

    public function detail()
    {
        $data = GoodsRepository::find(Input::get('id'));

        if($data){
            $json['message'] = '供需详情获取成功';
            $json['status_code'] = 200;
            $json['data'] = $data;
            return $json;
        }else{
            $json['message'] = '不存在该供求信息';
            $json['status_code'] = 400;
            $json['data'] = null;
            return $json;
        }
    }

}
