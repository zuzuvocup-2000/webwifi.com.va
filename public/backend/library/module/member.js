$(document).on('click', '.btn-open-discount', function(){
	let id = $(this).parents('tr').attr('data-id')
	let module = $(this).attr('data-module')
	$.post(
        "ajax/member/get_discount",
        {
            id: id,
            module: module
        },
        function (data) {
            let json = JSON.parse(data);
            if (json.response.code == 10){
                $('.table-discount tbody').html(json.response.html)
            }
        }
    );
})

$(document).ready(function () {
    if ($(".detail-member").length) {
        $(".detail-member").each(function () {
            let _this = $(this);
            let type = _this.attr("data-select");
            let data = _this.attr("data-variable");
            let module = _this.attr("data-module");
            console.log(data);
            if (data != "IiI=") {
                setTimeout(function () {
                    if (data != "") {
                        $.post(
                            "ajax/dashboard/pre_select2_dangvien",
                            {
                                value: data,
                                module: module,
                                type: type,
                            },
                            function (data) {
                                let json = JSON.parse(data);
                                if (json.items != "undefined" && json.items.length) {
                                    for (let i = 0; i < json.items.length; i++) {
                                        var option = new Option(json.items[i].text, json.items[i].id, true, true);
                                        _this.append(option).trigger("change");
                                    }
                                }
                            }
                        );
                    }
                }, 10);
            }

            select2_dangvien(_this);
        });
    }
});

function select2_dangvien(object) {
    let type = object.attr("data-select");
    let module = object.attr("data-module");
    object.select2({
        minimumInputLength: 2,
        maximumSelectionLength: 5,
        placeholder: "Nhập 2 từ khóa để tìm kiếm...",
        ajax: {
            url: "ajax/dashboard/dangvien_select2",
            type: "POST",
            dataType: "json",
            deley: 250,
            data: function (params) {
                return {
                    locationVal: params.term,
                    module: module,
                    type: type,
                };
            },
            processResults: function (data) {
                return {
                    results: $.map(data, function (obj, i) {
                        return obj;
                    }),
                };
            },
            cache: true,
        },
    });
}

$(document).on("click", ".btn-reset-pass", function () {
    let _this = $(this);
    let id = _this.parents("tr").attr("data-id");
    if (id.length > 0) {
        swal(
            {
                title: "Hãy chắc chắn rằng bạn muốn thực hiện thao tác này? Reset mật khẩu bằng phương thức gửi mail đến tài khoản!",
                text: "Xác nhận gửi Mail?",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Thực hiện!",
                cancelButtonText: "Hủy bỏ!",
                closeOnConfirm: false,
                closeOnCancel: false,
            },
            function (isConfirm) {
                if (isConfirm) {
                    var formURL = "ajax/member/reset_pass";
                    $.post(
                        formURL,
                        {
                            id: id,
                        },
                        function (data) {
                            let json = JSON.parse(data);
                            if (json.response.code == 99) {
                                sweet_error_alert("Có vấn đề xảy ra", "Vui lòng thử lại");
                            } else {
                                swal("Reset mật khẩu thành công!", "Xin vui lòng đăng nhập Email để lấy lại mật khẩu mới.", "success");
                                window.location.href = BASE_URL + "backend/member/member/index";
                            }
                        }
                    );
                } else {
                    swal("Hủy bỏ", "Thao tác bị hủy bỏ", "error");
                }
            }
        );
    }

    return false;
});
