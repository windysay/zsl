@extends('backend.layout.main')

@section('after.css')
    <link rel="stylesheet" type="text/css" href="/assets/backend/plugins/dropzone/dropzone.min.css">
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <button class="btn btn-box btn-success btn-flat"
                    data-toggle="modal"
                    data-target="#upload-modal">
                <i class="fa fa-upload"></i>
                上传
            </button>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">文件列表</h3>

                    <div class="box-tools"></div>
                </div>

                <div class="box-body table-responsive no-padding">
                    <table class="table table-hover">
                        <tr>
                            <th>文件编号</th>
                            <th>文件名称</th>
                            <th>文件大小</th>
                            <th>文件类型</th>
                            <th>创建时间</th>
                            <th>管理操作</th>
                        </tr>
                        @forelse($data as $file)
                            <tr>
                                <td>{{$file->id}}</td>
                                <td>{{$file->original_name}}</td>
                                <td>{{format_file_size($file->size)}}</td>
                                <td>{{$file->extension}}</td>
                                <td>{{$file->created_at}}</td>
                                <td>
                                    <a href="" class="btn btn-warning btn-flat">预览</a>
                                    <a href="" class="btn btn-info btn-flat">下载</a>
                                    <a href="" class="btn btn-danger btn-flat">删除</a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center">暂无数据</td>
                            </tr>
                        @endforelse
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

@section('after.js')
    @include('backend.components.modal.upload')
@endsection