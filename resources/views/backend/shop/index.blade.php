@extends("backend.layout.main")

@inject('actionPresenter','App\Presenters\ShopsPresenter')

@section("content")
    @include('backend.components.handle',$handle = $actionPresenter->getHandle())
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">商户列表</h3>

                    <div class="box-tools">{!! $data->render() !!}</div>
                </div>

                <div class="box-body table-responsive no-padding">
                    <table class="table table-hover">
                        <tr>
                            <th>商会ID</th>
                            <th>商会名</th>
                            <th>状态</th>
                            <th>客服电话</th>
                            <th>邮箱</th>
                            <th>注册人</th>
                            <th>操作</th>
                        </tr>
                        @foreach($data as $item)
                            <tr>
                                <td>{{$item->id}}</td>
                                <td>{{$item->shop_name}}</td>
                                <td>{{$item->status}}</td>
                                <td>{{$item->shop_tel}}</td>
                                <td>{{$item->shop_email}}</td>
                                <td>{{$item->user_name}}</td>
                                <td>
                                    <a href="{{route('backend.shop.edit',['id'=>$item->id])}}" class="btn btn-primary btn-flat">编辑</a>
                                    @if($item->ispass==1)
                                    <button class="btn btn-success btn-flat">已审核</button>
                                    @else
                                    <button class="btn-pass btn btn-default btn-flat" data-id="{{$item->id}}">审核</button>
                                    @endif
                                    <button class="btn btn-danger btn-flat"
                                            data-url="{{URL::to('backend/shop/'.$item->id)}}"
                                            data-toggle="modal"
                                            data-target="#delete-modal"
                                    >
                                        删除
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </table>
                </div>
                @if($data->render())
                    <div class="box-footer clearfix">
                        {!! $data->render() !!}
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
@section("after.js")
    @include('backend.components.modal.delete',['title'=>'操作提示','content'=>'你确定要删除这名用户吗?'])
    <script type="text/javascript">
        $(".btn-pass").click(function(){
            if(confirm("确定该商户通过审核?")){
                var id = $(this).attr('data-id');
                var objbutton = $(this);
                $.ajax({
                    type:'post',
                    url:'{{URL::to('backend/shop/pass?id=')}}'+id,
                    headers: {
                        'X-CSRF-TOKEN':'{{csrf_token()}}'
                    },
                    success:function(data){
                        if(data.success){
                            objbutton.text("已审核");
                            objbutton.attr("class","btn btn-success");
                        }else{
                            alert("审核失败");
                        }
                    }
                });
            }
        })
    </script>
@endsection

