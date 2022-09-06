$(document).ready(function(){
	$(document).on('click','.delete', function(){
	
		let _this = $(this);
		

		
		swal({
			title: "Hãy chắc chắn rằng bạn muốn thực hiện thao tác này? Dữ liệu bị xóa sẽ không thể khôi phục!",
			text: 'Xóa nhóm liên hệ này',
			type: "warning",
			showCancelButton: true,
			confirmButtonColor: "#DD6B55",
			confirmButtonText: "Thực hiện!",
			cancelButtonText: "Hủy bỏ!",
			closeOnConfirm: false,
			closeOnCancel: false },
		function (isConfirm) {
			if (isConfirm) {
				var formURL = 'ajax/contact/deleteContact';
				$.post(formURL, {
					id: id, module: _this.attr('data-module'), language: language},
					function(data){
						if(data == 0){
								sweet_error_alert('Có vấn đề xảy ra','Vui lòng thử lại')
							}else{
								swal("Xóa thành công!", "Bản ghi đã được xóa khỏi danh sách.", "success");
								window.location.href = BASE_URL+'backend/contact/catalogue/index';
							}
					});
			} else {
				swal("Hủy bỏ", "Thao tác bị hủy bỏ", "error");
			}
		});
		console.log(1);
		
		return false;
	});
});
