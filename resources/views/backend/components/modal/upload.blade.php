<div class="modal" id="upload-modal" tabindex="-1" role="dialog" aria-labelledby=updateModalLabel">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">上传文件</h4>
            </div>
            <div class="modal-body">
                <form class="dropzone" id="dropzone" style="border: 2px dashed #d2d6de;">
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-info" data-dismiss="modal" id="upload-finished">确定</button>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript" src="/assets/backend/plugins/dropzone/dropzone.min.js"></script>
<script type="text/javascript">
    $('#upload-finished').click(function () {
        window.location.reload();
    });

    Dropzone.options.dropzone = {
        url: "file/upload",
        method: "post",
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr('content')
        },
        paramName: "file",
        maxFilesize: 10,
        dictFileTooBig: "上传文件太大,无法上传!",
        dictResponseError: "上传文件出错,请联系管理员!",
        dictDefaultMessage: "拖动文件到此或点击上传",
        accept: function (file, done) {
            done();
        },
        success: function (file, done) {
            console.log(done);
        }
    };
</script>