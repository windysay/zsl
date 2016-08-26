@extends("backend.layout.main")

@inject('actionPresenter','App\Presenters\BusinessCirclePresenter')

@section("content")
    @include('backend.components.handle',$handle = $actionPresenter->getHandle())
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">商圈列表</h3>

                    <div class="box-tools">{!! $data->render() !!}</div>
                </div>

                <div class="box-body table-responsive no-padding">
                    <table class="table table-hover">
                        <tr>
                            <th>ID</th>
                            <th>商圈名</th>
                            <th>简介</th>
                            <th>logo</th>
                            <th>人数</th>
                            <th>操作</th>
                        </tr>
                        @foreach($data as $item)
                            <tr>
                                <td>{{$item->id}}</td>
                                <td>{{$item->name}}</td>
                                <td>{{$item->introduct}}</td>
                                <td><img src="{{$item->logo}}" alt="" width="30"></td>
                                <td>{{$item->number}}</td>
                                <td>
                                    <a href="{{route('backend.businesscircle.edit',['id'=>$item->id])}}" class="btn btn-primary btn-flat">编辑</a>
                                    <button class="btn btn-danger btn-flat"
                                            data-url="{{URL::to('backend/businesscircle/'.$item->id)}}"
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
    @include('backend.components.modal.delete',['title'=>'操作提示','content'=>'你确定要删除这个操作吗?'])
@endsection
