$(document).ready(function(){
		$(document).on('click','.deleteColor', function(){
		let _this = $(this);
		let code = _this.attr('code');

			swal({
				title: "Hãy chắc chắn rằng bạn muốn thực hiện thao tác này?",
				text: 'Xóa Bài viết này. Dữ liệu sẽ không thể khôi phục!',
				type: "warning",
				showCancelButton: true,
				confirmButtonColor: "#DD6B55",
				confirmButtonText: "Thực hiện!",
				cancelButtonText: "Hủy bỏ!",
				closeOnConfirm: false,
				closeOnCancel: false },
			function (isConfirm) {
				if (isConfirm) {
					var formURL = 'ajax/color/deleteColor';
					$.post(formURL, {
						code: code,},
						function(data){
							if(data == 0){
									sweet_error_alert('Có vấn đề xảy ra','Vui lòng thử lại')
								}else{
									swal("Xóa thành công!", "Bản ghi đã được xóa khỏi danh sách.", "success");
									window.location.href = BASE_URL+'backend/product/color/color/index';
								}
						});
				} else {
					swal("Hủy bỏ", "Thao tác bị hủy bỏ", "error");
				}
			});
		
		
		return false;
	});
	$(document).on('click','.update', function(){
	let value = [];
	let lang = [];
	let code = [];

	$('.colorTrans').each(function(){
		let _this = $(this);
	 	value.push(_this.val());
	 	lang.push(_this.attr('lang'));
	 	code.push(_this.attr('code'));
	});

	

	if(value.length > 0){
		swal({
			title: "Hãy chắc chắn rằng bạn muốn thực hiện thao tác này?",
			text: 'Cập nhật ngôn ngữ các màu đã thay đổi.',
			type: "warning",
			showCancelButton: true,
			confirmButtonColor: "#DD6B55",
			confirmButtonText: "Thực hiện!",
			cancelButtonText: "Hủy bỏ!",
			closeOnConfirm: false,
			closeOnCancel: false },
		function (isConfirm) {
			if (isConfirm) {
				var formURL = 'ajax/color/update';
				$.post(formURL, {
					value: value, lang: lang, code: code},
					function(data){
						if(data == 0){
								sweet_error_alert('Có vấn đề xảy ra','Vui lòng thử lại')
							}else{
								
								swal("Cập nhật thành công!", "Các bản ghi đã được cập nhật.", "success");
								window.location.href = BASE_URL+'backend/product/color/color/index';
							}
					});
			} else {
				swal("Hủy bỏ", "Thao tác bị hủy bỏ", "error");
			}
		});
	}
	
	return false;
});
	
	

	
});