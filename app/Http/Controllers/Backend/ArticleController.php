<?php

namespace App\Http\Controllers\Backend;

use App\Facades\ArticleRepository;
use App\Facades\ArticleCatRepository;
use App\Http\Requests\Form\ArticleCreateForm;
use App\Http\Requests;
use App\Http\Controllers\Controller;

/**
 * 文章管理控制器
 *
 * @package App\Http\Controllers\Backend
 */
class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response1
     */
    public function index()
    {
        $data = ArticleRepository::paginate(config('repository.page-limit'));
        $cat = create_articlecat_list(ArticleCatRepository::all()->toArray());
        $type = ['article'=>'文章','url'=>'网页链接','video'=>'视频'];

        return view('backend.article.index', compact("data", "cat", "type"));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $tree = create_level_tree(ArticleCatRepository::all()->toArray());

        return view('backend.article.create', compact('tree'));
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
            $data = $request->except(['_token', 'file']);
            if (ArticleRepository::create($data)) {
                return $this->successRoutTo("backend.article.index", "新增文章成功");
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
        $data = ArticleRepository::find($id);
        $tree = create_level_tree(ArticleCatRepository::all()->toArray());

        return view('backend.article.edit', compact('data', 'tree'));
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
        $role = ArticleRepository::find($id);
        $role->title = $request['title'];
        $role->cat_id = $request['cat_id'];
        $role->logo = $request['logo'];
        $role->url = $request['url'];
        $role->content = $request['content'];
        $role->ifpub = $request['ifpub'];
        $role->type = $request['type'];

        try {
            if ($role->save()) {
                return $this->successBackTo("编辑文章成功");
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
            if (ArticleRepository::destroy($id)) {
                return $this->successBackTo("删除文章成功");
            }
        }
        catch (\Exception $e) {
            return $this->errorBackTo(['error' => $e->getMessage()]);
        }
    }

}
