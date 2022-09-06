$(document).ready(function(){
		$(document).on('click','.deleteCatalogue', function(){


		let _this = $(this);
		let id = _this.attr('id');

			swal({
				title: "Hãy chắc chắn rằng bạn muốn thực hiện thao tác này?",
				text: 'Xóa nhóm thuộc tính này. Các thuộc tính con sẽ bị xóa!',
				type: "warning",
				showCancelButton: true,
				confirmButtonColor: "#DD6B55",
				confirmButtonText: "Thực hiện!",
				cancelButtonText: "Hủy bỏ!",
				closeOnConfirm: false,
				closeOnCancel: false },
			function (isConfirm) {
				if (isConfirm) {
					var formURL = 'ajax/attribute/deleteCatalogue';
					$.post(formURL, {
						id: id,},
						function(data){
							if(data == 0){
									sweet_error_alert('Có vấn đề xảy ra','Vui lòng thử lại')
								}else{
									swal("Xóa thành công!", "Bản ghi đã được xóa khỏi danh sách.", "success");
									window.location.href = BASE_URL+'backend/attribute/catalogue/index';
								}
						});
				} else {
					swal("Hủy bỏ", "Thao tác bị hủy bỏ", "error");
				}
			});
		
		
		return false;
	});
});