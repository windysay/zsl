@extends('backend.layout.main')

@section('content')
    @include('UEditor::head')
    <div class="row">
        <div class="col-md-12">
            <form action="{{route('backend.goods.update',['id'=>$data->id])}}" method="post">
                <input type="hidden" name="_token" value="{{csrf_token()}}">
                <input type="hidden" name="_method" value="put">
                <div class="box">
                    <div class="box-header with-border">
                        <h3 class="box-title">编辑供求信息</h3>
                    </div>
                    <div class="box-body">
                        <div class="form-group">
                            <label>供需类型</label>
                            <select class="form-control select2" style="width: 100%;" name="type">
                                @foreach($type as $key=>$value)
                                    <option value="{{$key}}">
                                        {{ $value }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="name">标题</label>
                            <input type="text" class="form-control" id="title" name="title" placeholder="文章标题" value="{{$data->title}}">
                        </div>
                        <div class="form-group">
                            <label for="name">简介</label>
                            <input type="text" class="form-control" id="introduct" name="introduct" placeholder="简介" value="{{$data->introduct}}">
                        </div>
                        <div class="form-group">
                            <label for="logo">图片</label>
                            <input type="file" class="form-control" id="file" name="file">
                            <input type="hidden" id="image" name="images" value="{{$data->images or ''}}">
                            @if(!empty($data->images))
                                <img src="{{$data->images}}" alt="{{$data->title}}" id="preview" style="margin-top: 10px;border-radius: 10px;max-height:100px;">
                            @else
                                <img src="" alt="" id="preview" style="margin-top: 10px;border-radius: 10px;max-height:100px;">
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="name">详情</label>
                            <input type="text" class="form-control" id="introduct" name="descript" placeholder="详情" value="{{$data->descript}}">
                        </div>
                        <div class="form-group">
                            <label for="user_name">联系人姓名</label>
                            <input type="user_name" class="form-control" id="url" name="user_name" placeholder="联系人姓名" value="{{$data->user_name}}">
                        </div>
                        <div class="form-group">
                            <label for="user_mobile">联系人电话</label>
                            <input type="text" class="form-control" id="url" name="user_mobile" placeholder="联系人电话" value="{{$data->user_mobile}}">
                        </div>
                        <div class="form-group">
                            <label for="user_email">联系人邮箱</label>
                            <input type="text" class="form-control" id="url" name="user_email" placeholder="联系人邮箱" value="{{$data->user_email}}">
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

