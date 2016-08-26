<?php

namespace App\Http\Controllers\Backend;

use App\Facades\GoodsRepository;
use App\Http\Requests\Form\ArticleCreateForm;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Mail;

/**
 * 供需信息管理控制器
 *
 * @package App\Http\Controllers\Backend
 */
class GoodsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = GoodsRepository::paginate(config('repository.page-limit'));
        $type = ['give'=>'供应信息','need'=>'需求信息'];

        return view('backend.goods.index', compact("data", "type"));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $type = ['give'=>'供应信息','need'=>'需求信息'];

        return view('backend.goods.create', compact('type'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\Form\RoleCreateForm $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(ArticleCreateForm $request)
    {
        try {
            if (GoodsRepository::create($request->all())) {
                return $this->successRoutTo("backend.goods.index", "新增供需信息成功");
            }
        }
        catch (\Exception $e) {
            return $this->errorBackTo(['error' => $e->getMessage()]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     *
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
        $data = GoodsRepository::find($id);
        $type = ['give'=>'供应信息','need'=>'需求信息'];

        return view('backend.goods.edit', compact('data', 'type'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\Form\RoleCreateForm $request
     * @param  int                                    $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(ArticleCreateForm $request, $id)
    {
        $role = GoodsRepository::find($id);
        $role->title = $request['title'];
        $role->type = $request['type'];
        $role->introduct = $request['introduct'];
        $role->descript = $request['descript'];
        $role->images = $request['images'];
        $role->user_name = $request['user_name'];
        $role->user_mobile = $request['user_mobile'];
        $role->user_email = $request['user_email'];

        try {
            if ($role->save()) {
                return $this->successBackTo("编辑供需信息成功");
            }
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
            if (GoodsRepository::destroy($id)) {
                return $this->successBackTo("删除供需信息成功");
            }
        }
        catch (\Exception $e) {
            return $this->errorBackTo(['error' => $e->getMessage()]);
        }
    }

    //供需通过审核
    public function pass(){
        $id = Input::get('id');
        if($id){
            try{
                GoodsRepository::saveById($id, ['ispass'=>1]);
            }catch (\LogicException $e){
                return response()->json(['success' => 'false',]);
            }
            /** 发送邮件通知商户 */
            $text = '您好, 你的申请已经通过审核. ——中国联盟商会';
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
