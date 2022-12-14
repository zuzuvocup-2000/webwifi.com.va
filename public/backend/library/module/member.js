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
        placeholder: "Nh???p 2 t??? kh??a ????? t??m ki???m...",
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
                title: "H??y ch???c ch???n r???ng b???n mu???n th???c hi???n thao t??c n??y? Reset m???t kh???u b???ng ph????ng th???c g???i mail ?????n t??i kho???n!",
                text: "X??c nh???n g???i Mail?",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Th???c hi???n!",
                cancelButtonText: "H???y b???!",
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
                                sweet_error_alert("C?? v???n ????? x???y ra", "Vui l??ng th??? l???i");
                            } else {
                                swal("Reset m???t kh???u th??nh c??ng!", "Xin vui l??ng ????ng nh???p Email ????? l???y l???i m???t kh???u m???i.", "success");
                                window.location.href = BASE_URL + "backend/member/member/index";
                            }
                        }
                    );
                } else {
                    swal("H???y b???", "Thao t??c b??? h???y b???", "error");
                }
            }
        );
    }

    return false;
});
