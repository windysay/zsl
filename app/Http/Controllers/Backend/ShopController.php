<?php

namespace App\Http\Controllers\Backend;

use App\Facades\ShopRepository;
use App\Facades\UserRepository;
use App\Models\Shop;
use App\Models\User;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Requests\Form\ShopCreateForm;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Mail;

/**
 * 商会管理控制器
 *
 * @package App\Http\Controllers\Backend
 */
class ShopController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = ShopRepository::paginate(config('repository.page-limit'));

        return view("backend.shop.index", compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("backend.shop.create");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\Form\UserCreateForm $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(ShopCreateForm $request)
    {
        $data = [
            'cat_id'=>$request['cat_id'],
            'store_id'=>$request['store_id'],
            'ispass'=>'1',
            'shop_name'=>$request['shop_name'],
            'shop_descript'=>$request['shop_descript'],
            'status'=>$request['status'],
            'shop_logo'=>$request['shop_logo'],
            //'shop_banner'=>$request['shop_banner'],
            'shop_tel'=>$request['shop_tel'],
            'shop_email'=>$request['shop_email'],
            'area'=>$request['area'],
            'addr'=>$request['addr'],
            'shop_url'=>$request['shop_url'],
            'shop_qrcode'=>$request['shop_qrcode'],
            'lng'=>$request['lng'],
            'lat'=>$request['lat'],
            'user_name'=>$request['user_name'],
            'user_mobile'=>$request['user_mobile'],
            'user_email'=>$request['user_email'],
            'shop_logo'=>$request['shop_logo'],
        ];
        $udata = [
            'name'=>$request['user_mobile'],
            'email'=>$request['user_email'],
            'password'=>bcrypt($request['password']),
            'is_super_admin'=>0,
        ];
        try {
            DB::beginTransaction();
            $user_unique = User::where('email',$udata['email'])->first();
            /* 若是新用户创建用户 */
            if(!$user_unique) {
                $user_unique = UserRepository::create($udata);
            }
            $data['user_id'] = $user_unique['id'];
            Shop::create($data);
        }
        catch (\Exception $e) {
            DB::rollBack();
            return $this->errorBackTo(['error' => $e->getMessage()]);
        }
        DB::commit();
        return $this->successRoutTo('backend.shop.index', '新增商户成功');
    }

    /**
     * Display the specified resource
     *
     * @param  int $id
     *e
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $shop = ShopRepository::find($id);

        return view('backend.shop.edit', compact('shop'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\Form\UserUpdateForm $request
     * @param  int                                    $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(ShopCreateForm $request, $id)
    {
        try {
            $data = [
                'cat_id'=>$request['cat_id'],
                'store_id'=>$request['store_id'],
                'shop_name'=>$request['shop_name'],
                'shop_descript'=>$request['shop_descript'],
                'status'=>$request['status'],
                'shop_logo'=>$request['shop_logo'],
                //'shop_banner'=>$request['shop_banner'],
                'shop_tel'=>$request['shop_tel'],
                'shop_email'=>$request['shop_email'],
                'area'=>$request['area'],
                'addr'=>$request['addr'],
                'shop_url'=>$request['shop_url'],
                'shop_qrcode'=>$request['shop_qrcode'],
                'lng'=>$request['lng'],
                'lat'=>$request['lat'],
                'user_name'=>$request['user_name'],
                'user_mobile'=>$request['user_mobile'],
                'user_email'=>$request['user_email'],
                'shop_logo'=>$request['shop_logo'],
            ];
            ShopRepository::saveById($id, $data);
            return $this->successRoutTo('backend.shop.index', "编辑商户成功");
        }
        catch (\Exception $e) {
            return $this->errorBackTo(['error' => $e->getMessage()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            if (ShopRepository::destroy($id)) {
                return $this->successBackTo('删除商户成功');
            }
        }
        catch (\Exception $e) {
            return $this->errorBackTo(['error' => $e->getMessage()]);
        }
    }

    //商户通过审核
    public function pass(){
        $id = Input::get('id');
        if($id){
            try{
                ShopRepository::saveById($id, ['ispass'=>1]);
            }catch (\LogicException $e){
                return response()->json(['success' => 'false',]);
            }
            /** 发送邮件通知商户 */
            $text = '您好, 你的申请已经通过审核, 请尽快登录APP完善资料. ——中国联盟商会 ';
            $title = '你的申请已经通过审核';
            Mail::send('emails.message', ['text' => $text], function ($email) use ($text, $title) {
                $email->to(env('ADMIN_EMAIL'))->subject($title);
            });
            return response()->json(['success' => 'true',]);
        }else{
            return response()->json(['success' => 'false',]);
        }
    }
}
