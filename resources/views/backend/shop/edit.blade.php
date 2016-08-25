@extends('backend.layout.main')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <form action="{{route('backend.shop.update',['id'=>$shop->id])}}" method="post">
                <input type="hidden" name="_token" value="{{csrf_token()}}">
                <input type="hidden" name="_method" value="put">
                <div class="box">
                    <div class="box-header with-border">
                        <h3 class="box-title">编辑商户</h3>
                    </div>
                    <div class="box-body">
                        <div class="box-body">
                            <div class="form-group">
                                <label>商户类型</label>
                                <select class="form-control select2" name="cat_id" style="width: 100%;">
                                    @foreach(config('shop.shop_cat') as $key => $cat)
                                        <option value="{{$key}}" @if($key == $shop->cat_id) selected @endif>{{$cat}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label>商户商号</label>
                                <select class="form-control select2" name="store_id" style="width: 100%;">
                                    @foreach(config('shop.shop_store') as $key => $store)
                                        <option value="{{$key}}" @if($key== $shop->store_id) selected @endif>{{$store}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="shop_name">商会名</label>
                                <input type="shop_name" class="form-control" id="name" name="shop_name" placeholder="商会名" value="{{$shop->shop_name}}">
                            </div>
                            <div class="form-group">
                                <label for="shop_descript">描述</label>
                                <!-- 加载编辑器的容器 -->
                                @include('UEditor::head')
                                <script id="container" name="shop_descript" type="text/plain">{!! $shop->shop_descript !!}</script>
                                <!-- 实例化编辑器 -->
                                <script type="text/javascript">
                                    var ue = UE.getEditor('container',{
                                    });
                                    ue.ready(function() {
                                        ue.execCommand('serverparam', '_token', '{{ csrf_token() }}');//此处为支持laravel5 csrf ,根据实际情况修改,目的就是设置 _token 值.
                                    });
                                </script>
                            </div>
                            <div class="form-group">
                                <label for="shop_qrcode">商会logo</label>
                                <input type="file" class="form-control" id="file" name="file">
                                <input type="hidden" id="image" name="shop_logo" value="{{$shop->shop_logo or ''}}">
                                @if(!empty($shop->shop_logo))
                                    <img src="{{$shop->shop_logo}}" alt="{{$shop->shop_name}}" id="preview" style="margin-top: 10px;border-radius: 10px;max-height:100px;">
                                @else
                                    <img src="" alt="" id="preview" style="margin-top: 10px;border-radius: 10px;max-height:100px;">
                                @endif
                            </div>
                            <div class="form-group">
                                <label>商户状态</label>
                                <select class="form-control select2" name="status" style="width: 100%;">
                                    <option value="active">已激活</option>
                                    <option value="unactive">未激活</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="shop_tel">客服电话</label>
                                <input type="text" class="form-control" id="shop_tel" name="shop_tel" placeholder="客服电话" value="{{$shop->shop_tel}}">
                            </div>
                            <div class="form-group">
                                <label for="email">邮箱</label>
                                <input type="text" class="form-control" id="email" name="shop_email" placeholder="邮箱" value="{{$shop->shop_email}}">
                            </div>
                            <div class="form-group">
                                <label for="addr">详细地址</label>
                                <input type="text" class="form-control" id="addr" name="addr" placeholder="详细地址" value="{{$shop->addr}}">
                            </div>
                            <div class="form-group">
                                <label for="email">官网网址</label>
                                <input type="text" class="form-control" id="shop_url" name="shop_url" placeholder="官网网址" value="{{$shop->shop_url}}">
                            </div>
                            <div class="form-group">
                                <label for="shop_qrcode">微信二维码</label>
                                <input type="file" class="form-control" id="file1" name="file">
                                <input type="hidden" id="image" name="shop_qrcode" value="{{$shop->shop_qrcode or ''}}">
                                @if(!empty($shop->shop_qrcode))
                                    <img src="{{$shop->shop_qrcode}}" alt="{{$shop->shop_name}}" id="preview" style="margin-top: 10px;border-radius: 10px;max-height:100px;">
                                @else
                                    <img src="" alt="" id="preview" style="margin-top: 10px;border-radius: 10px;max-height:100px;">
                                @endif
                            </div>
                            <div class="form-group">
                                <label for="lng">经度</label>
                                <input type="text" class="form-control" id="lng" name="lng" placeholder="经度" value="{{$shop->lng}}">
                            </div>
                            <div class="form-group">
                                <label for="lat">纬度</label>
                                <input type="text" class="form-control" id="lat" name="lat" placeholder="纬度" value="{{$shop->lat}}">
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
              </div>
            </form>
        </div>
    </div>
@endsection
@section('after.js')
    <script type="text/javascript">
        $(function () {
            $('#file').on('change', function () {
                var fileObj = $(this);
                var formdata = new FormData();  //构建空的formdata对象(HTML5)
                formdata.append("file", fileObj[0].files[0]); //增加上传文件
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
                    fileObj.parent().find('#image').attr('value', url);
                    fileObj.parent().find('#preview').attr('src', url);
                }).fail(function (response) {
                    console.log(response);
                });
            });
            $('#file1').on('change', function () {
                var fileObj = $(this);
                var formdata = new FormData();  //构建空的formdata对象(HTML5)
                formdata.append("file", fileObj[0].files[0]); //增加上传文件
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
                    fileObj.parent().find('#image').attr('value', url);
                    fileObj.parent().find('#preview').attr('src', url);
                }).fail(function (response) {
                    console.log(response);
                });
            });
        });
    </script>
@endsection

