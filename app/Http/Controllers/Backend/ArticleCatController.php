<?php

namespace App\Http\Controllers\Backend;

use App\Facades\ArticleCatRepository;
use App\Http\Requests\Form\ArticleCatCreateForm;
use App\Http\Requests;
use App\Http\Controllers\Controller;

/**
 * 文章管理控制器
 *
 * @package App\Http\Controllers\Backend
 */
class ArticleCatController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response1
     */
    public function index()
    {
        $data = ArticleCatRepository::paginate(config('repository.page-limit'));

        return view('backend.articlecat.index', compact("data"));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $tree = create_level_tree(ArticleCatRepository::all()->toArray());

        return view('backend.articlecat.create', compact('tree'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\Form\RoleCreateForm $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(ArticleCatCreateForm $request)
    {
        try {
            if (ArticleCatRepository::create($request->all())) {
                return $this->successRoutTo("backend.articlecat.index", "新增栏目成功");
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
        $data = ArticleCatRepository::find($id);
        $tree = create_level_tree(ArticleCatRepository::all()->toArray());

        return view('backend.articlecat.edit', compact('data', 'tree'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\Form\RoleCreateForm $request
     * @param  int                                    $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(ArticleCatCreateForm $request, $id)
    {
        $role = ArticleCatRepository::find($id);
        $role->cat_name = $request['cat_name'];
        $role->parent_id = $request['parent_id'];
        $role->sort = $request['sort'];

        try {
            if ($role->save()) {
                return $this->successBackTo("编辑栏目成功");
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
            if (ArticleCatRepository::destroy($id)) {
                return $this->successBackTo("删除栏目成功");
            }
        }
        catch (\Exception $e) {
            return $this->errorBackTo(['error' => $e->getMessage()]);
        }
    }

}
