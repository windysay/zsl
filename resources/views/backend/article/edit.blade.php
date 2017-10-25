@extends('backend.layout.main')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <form action="{{route('backend.article.update',['id'=>$data->id])}}" method="post">
                <input type="hidden" name="_token" value="{{csrf_token()}}">
                <input type="hidden" name="_method" value="put">
                <div class="box">
                    <div class="box-header with-border">
                        <h3 class="box-title">编辑文章</h3>
                    </div>
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
                            <input type="text" class="form-control" id="title" name="title" placeholder="文章标题" value="{{$data->title}}">
                        </div>
                        <div class="form-group">
                            <label for="logo">文章logo</label>
                            <input type="file" class="form-control" id="file" name="file">
                            <input type="hidden" id="image" name="logo" value="{{$data->logo or ''}}">
                            @if(!empty($data->logo))
                                <img src="{{$data->logo}}" alt="{{$data->title}}" id="preview" style="margin-top: 10px;border-radius: 10px;max-height:100px;">
                            @else
                                <img src="" alt="" id="preview" style="margin-top: 10px;border-radius: 10px; max-height:100px;">
                            @endif
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
                            <input type="text" class="form-control" id="url" name="url" placeholder="网页/视频链接" value="{{$data->url}}">
                        </div>
                        <div class="form-group">
                            <label for="name">文章内容</label>
                            <!-- 加载编辑器的容器 -->
                            @include('UEditor::head')
                            <script id="container" name="content" type="text/plain">{!! $data->content !!}</script>
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
                            <i class="fa fa-save"></i>
                            修 改
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
@section('after.js')
    <script type="text/javascript">
        $(function () {
            $('#file').on('change', function () {
                var formdata = new FormData();  //构建空的formdata对象(HTML5)
                formdata.append("file", $("#file")[0].files[0]); //增加上传文件
                $.ajax({
                    url: '{{route("backend.user.upload-avatar")}}',
                    type: 'POST',
                    cache: false,
                    data: formdata,
                    processData: false,
                    contentType: false,
                    headers: {
                        'X-CSRF-TOKEN':'{{csrf_token()}}'
                    },
                }).done(function (response) {
                    var url = response.data.url;
                    $('#image').attr('value', url);
                    $('#preview').attr('src', url);
                }).fail(function (response) {
                    console.log(response);
                });
            });
        });
    </script>
@endsection

