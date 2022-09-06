<div id="add_combo" class="modal fade va-general">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <div class="uk-flex uk-flex-space-between uk-flex-middle">
                    <h4 class="modal-title">Chỉnh sửa thông tin sản phẩm</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
            </div>
            <div class="modal-body">
                <div class="add-new-combo-box">
                    <form method="post" class="uk-clearfix form-edit-product">
                        <div class="row mb15">
                            <div class="col-lg-12">
                                <div class="form-row">
                                    <label class="control-label text-left">
                                        <span>Tiêu đề Sản phẩm <b class="text-danger">(*)</b></span>
                                    </label>
                                    <?php echo form_input('title', '', 'class="form-control " placeholder="" id="title" autocomplete="off"'); ?>
                                </div>
                            </div>
                        </div>
                        <div class="row mb15">
                            <div class="col-lg-12">
                                <div class="form-row form-description">
                                    <div class="uk-flex uk-flex-middle uk-flex-space-between">
                                        <label class="control-label text-left">
                                            <span>Mô tả ngắn</span>
                                        </label>
                                        <a href="" title="" data-target="description" class="uploadMultiImage">Upload hình ảnh</a>
                                    </div>
                                    <?php echo form_textarea('description',  '', 'class="form-control ck-editor-product" id="description" placeholder="" autocomplete="off"');?>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-row mb15">
                                    <div class="uk-flex uk-flex-middle uk-flex-space-between">
                                        <label class="control-label text-left">
                                            <span>Nội dung</span>
                                        </label>
                                        <a href="" title="" data-target="content" class="uploadMultiImage">Upload hình ảnh</a>
                                    </div>
                                    <?php echo form_textarea('content',  '', 'class="form-control ck-editor-product" id="content" placeholder="" autocomplete="off"');?>
                                </div>
                            </div>
                        </div>
                        <button type="submit" name="create" value="create" class="btn btn-primary block m-b pull-right btn-submit-update-modal">Lưu</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).on("click", ".btn-submit-update-modal", function () {
        let _this = $(this);
        let id = _this.attr("data-id");
        let module = _this.attr("data-module");
        let form = {
            title: $("#title").val(),
            description: CKEDITOR.instances.description.getData(),
            content: CKEDITOR.instances.content.getData(),
        };
        $.post(
            "ajax/product/update_object",
            {
                id: id,
                module: module,
                form: form,
            },
            function (data) {
                let response = JSON.parse(data);
                if (response.code == 10) {
                    $(".dataTables-example")
                        .find("#product-" + id + " .title .maintitle")
                        .html(form.title);
                    $("#add_combo").modal("hide");
                    toastr.success(response.message);
                } else {
                    if (response.code == 404 || response.code == 500) {
                        toastr.error(response.message);
                    } else {
                        toastr.error("Có lỗi xảy ra! Xin vui lòng thử lại");
                    }
                }
            }
        );
        return false;
    });

    $(document).on("click", ".edit-info-product", function () {
        let _this = $(this);
        let id = _this.attr("data-id");
        let module = _this.attr("data-module");

        if (CKEDITOR.instances.description) CKEDITOR.instances.description.destroy()
        if (CKEDITOR.instances.content) CKEDITOR.instances.content.destroy()
        $.post(
            "ajax/product/get_product_detail",
            {
                id: id,
                module: module,
            },
            function (data) {
                let response = JSON.parse(data);
                if (response.code == 10) {
                    $("#title").val(response.data.title);
                    $("#description").val(response.data.description);
                    $("#content").val(response.data.content);
                    $(".btn-submit-update-modal").attr("data-id", id);
                    $(".btn-submit-update-modal").attr("data-module", module);
                    $(".ck-editor-product").each(function () {
                        ckeditor5($(this).attr("id"));
                    });
                    toastr.success(response.message);
                } else {
                    if (response.code == 404 || response.code == 500) {
                        toastr.error(response.message);
                    } else {
                        toastr.error("Có lỗi xảy ra! Xin vui lòng thử lại");
                    }
                }
            }
        );
    });
</script>
