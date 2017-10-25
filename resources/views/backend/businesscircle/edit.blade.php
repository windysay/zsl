@extends('backend.layout.main')

@section('content')
    @include('UEditor::head')
    <div class="row">
        <div class="col-md-12">
            <form action="{{route('backend.businesscircle.update',['id'=>$data->id])}}" method="post">
                <input type="hidden" name="_token" value="{{csrf_token()}}">
                <input type="hidden" name="_method" value="put">
                <div class="box">
                    <div class="box-header with-border">
                        <h3 class="box-title">编辑商圈</h3>
                    </div>
                    <div class="box-body">
                        <div class="form-group">
                            <label for="name">商圈名</label>
                            <input type="text" class="form-control" id="title" name="name" placeholder="商圈名" value="{{$data->name}}">
                        </div>
                        <div class="form-group">
                            <label for="name">简介</label>
                            <input type="text" class="form-control" id="introduct" name="introduct" placeholder="简介" value="{{$data->introduct}}">
                        </div>
                        <div class="form-group">
                            <label for="logo">Logo</label>
                            <input type="file" class="form-control" id="file" name="logo">
                            <input type="hidden" id="image" name="logo" value="{{$data->logo or ''}}">
                            @if(!empty($data->logo))
                                <img src="{{$data->logo}}" alt="{{$data->title}}" id="preview" style="margin-top: 10px;border-radius: 10px;height:100px;">
                            @else
                                <img src="" alt="" id="preview" style="margin-top: 10px;border-radius: 10px;">
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="name">人数</label>
                            <input type="number" class="form-control" id="introduct" name="number" placeholder="人数" value="{{$data->number}}">
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

