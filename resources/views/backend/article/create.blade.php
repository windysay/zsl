@extends('backend.layout.main')
@section('content')
    @include('UEditor::head')
    <div class="row">
        <div class="col-md-12">
            <form method="post" action="{{route('backend.article.store')}}">
                <div class="box">
                    <div class="box-header with-border">
                        <h3 class="box-title">新增文章</h3>
                    </div>
                    {{csrf_field()}}
                    <div class="box-body">
                        <div class="form-group">
                            <label>文章栏目</label>
                            <select class="form-control select2" style="width: 100%;" name="cat_id">
                                @foreach($tree as $item)
                                    <option value="{{$item['id']}}">
                                        {{ $item['html'] }}{{ trans($item['cat_name']) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="name">文章标题</label>
                            <input type="text" class="form-control" id="title" name="title" placeholder="文章标题" value="{{old('title')}}">
                        </div>
                        <div class="form-group">
                            <label for="logo">文章logo</label>
                            <input type="file" class="form-control" id="logo" name="logo" value="{{old('logo')}}">
                        </div>
                        <div class="form-group">
                            <label for="type">文章是否发布</label>
                            <select class="form-control select2" style="width: 100%;" name="ifpub">
                                <option value="1">立即发布</option>
                                <option value="0">稍后发布</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="type">文章类型</label>
                            <select class="form-control select2" style="width: 100%;" name="type">
                                <option value="article">文章</option>
                                <option value="url">链接</option>
                                <option value="video">视频</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="name">网页/视频链接</label>
                            <input type="text" class="form-control" id="url" name="url" placeholder="网页/视频链接" value="{{old('url')}}">
                        </div>
                        <div class="form-group">
                            <label for="name">文章内容</label>
                            <!-- 加载编辑器的容器 -->
                            <script id="container" name="content" type="text/plain">
                            </script>
                            <!-- 实例化编辑器 -->
                            <script type="text/javascript">
                                var ue = UE.getEditor('container',{
                                });
                                ue.ready(function() {
                                    ue.execCommand('serverparam', '_token', '{{ csrf_token() }}');//此处为支持laravel5 csrf ,根据实际情况修改,目的就是设置 _token 值.
                                });
                            </script>
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

