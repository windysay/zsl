@extends('backend.layout.main')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <form method="post" action="{{route('backend.articlecat.store')}}">
                <div class="box">
                    <div class="box-header with-border">
                        <h3 class="box-title">新增栏目</h3>
                    </div>
                    {{csrf_field()}}
                    <div class="box-body">
                        <div class="form-group">
                            <label>父级栏目</label>
                            <select class="form-control select2" style="width: 100%;" name="parent_id">
                                <option selected="selected" value="0">顶级栏目</option>
                                @foreach($tree as $item)
                                    <option value="{{$item['id']}}">
                                        {{ $item['html'] }}{{ trans($item['cat_name']) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="name">栏目名称</label>
                            <input type="text" class="form-control" id="name" name="cat_name" placeholder="栏目名称" value="{{old('cat_name')}}">
                        </div>
                        <div class="form-group">
                            <label for="sort">栏目排序</label>
                            <input type="text" class="form-control" id="sort" name="sort" placeholder="栏目排序" value="0" value="{{old('sort')}}">
                        </div>
                    </div>
                    <div class="box-footer clearfix">
                        <a href="javascript:history.back(-1);" class="btn btn-default btn-flat">
                            <i class="fa fa-arrow-left"></i>
                            返回
                        </a>
                        <button type="submit" class="btn btn-success pull-right btn-flat">
                            <i class="fa fa-plus"></i>
                            新 增
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
