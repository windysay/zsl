@extends('backend.layout.main')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <form action="{{route('backend.menu.update',['id'=>$data->id])}}" method="post">
                <input type="hidden" name="_token" value="{{csrf_token()}}">
                <input type="hidden" name="_method" value="put">
                <input type="hidden" name="id" value="{{$data->id}}">
                <div class="box">
                    <div class="box-header with-border">
                        <h3 class="box-title">编辑菜单</h3>
                    </div>
                    <div class="box-body">
                        <div class="form-group">
                            <label>菜单上级</label>
                            <select class="form-control select2" style="width: 100%;" name="parent_id">
                                <option selected="selected" value="0">顶级分类</option>
                                @foreach($tree as $item)
                                    <option value="{{$item['id']}}" @if($data['parent_id'] == $item['id']) selected="selected" @endif>
                                        {{ $item['html'] }}{{ trans($item['name']) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="name">菜单名称</label>
                            <input type="text" class="form-control" id="name" name="name" placeholder="菜单名称" value="{{$data->name}}">
                        </div>
                        <div class="form-group">
                            <label for="description">菜单描述</label>
                            <input type="text" class="form-control" id="description" name="description" placeholder="菜单描述" value="{{$data->description}}">
                        </div>
                        <div class="form-group">
                            <label for="route">菜单路由</label>
                            <input type="text" class="form-control" id="route" name="route" placeholder="菜单路由" value="{{$data->route}}">
                        </div>
                        <div class="form-group">
                            <label for="icon">菜单图标</label>
                            <input type="text" class="form-control" id="icon" name="icon" placeholder="菜单图标" value="{{$data->icon}}">
                        </div>
                        <div class="form-group">
                            <label for="sort">菜单排序</label>
                            <input type="text" class="form-control" id="sort" name="sort" placeholder="菜单排序" value="{{$data->sort}}">
                        </div>
                        <div class="form-group">
                            <label for="hide">是否隐藏</label>
                            <div class="form-group">
                                <select class="form-control select2" name="hide">
                                    <option
                                            @if($data->hide == 0)
                                            selected="selected"
                                            @endif
                                            value="0">显示
                                    </option>
                                    <option
                                            @if($data->hide == 1)
                                            selected="selected"
                                            @endif
                                            value="1">隐藏
                                    </option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="box-footer clearfix">
                        <a href="javascript:history.back(-1);" class="btn btn-default btn-flat">
                            <i class="fa fa-arrow-left"></i>
                            返回
                        </a>
                        <button type="submit" class="btn btn-success pull-right btn-flat">
                            <i class="fa fa-save"></i>
                            修 改
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

