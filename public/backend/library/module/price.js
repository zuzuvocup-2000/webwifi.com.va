$(document).ready(function(){
	$('body').on('change', '.select_system_price', function(){
		let val = $(this).find(':selected').val();
		let ajaxUrl = "ajax/price/set_catalogue_price";
		$('.system-general').addClass('hidden')
		if(val != ''){
			$.ajax({
				method: "POST",
				url: ajaxUrl,
				data: {val: val},
				success: function(data){
					if(val.trim() == 'normal'){
						$('.system-normal').removeClass('hidden')
					}else{
						$('.system-auto').removeClass('hidden')
					}
				}
			});
		}
	})

	$('body').on('click', '.btn-save-auto', function(){
		let apikey = $('.apikey').val();
		let secretkey = $('.secretkey').val();
		let ajaxUrl = "ajax/price/set_value_auto";
		if(apikey == ''){
			toastr.error('Có lỗi xảy ra!','Xin vui lòng điền API key!');
		}else if(secretkey == ''){
			toastr.error('Có lỗi xảy ra!','Xin vui lòng điền Secret key!');

		}else{
			$.ajax({
				method: "POST",
				url: ajaxUrl,
				data: {apikey: apikey,secretkey: secretkey},
				success: function(data){
					toastr.success('Thành công!','Cập nhật thành công!');
					
				}
			});
		}
	})

	$('body').on('click', '.btn-save-normal', function(){
		let price = $('.input-price').val();
		let district = $('.select-district').find(':selected').val();
		let city = $('.select-city').find(':selected').val();
		let ajaxUrl = "ajax/price/set_value_normal";
		if(price == ''){
			toastr.error('Có lỗi xảy ra!','Xin vui lòng điền Giá Ship!');
		}else if(city == 0){
			toastr.error('Có lỗi xảy ra!','Xin vui lòng chọn Tỉnh - Thành phố!');

		}else if(district == 0){
			toastr.error('Có lỗi xảy ra!','Xin vui lòng chọn Quận - huyện!');

		}else{
			$.ajax({
				method: "POST",
				url: ajaxUrl,
				data: {price: price,city: city,district: district},
				success: function(data){
					let json = JSON.parse(data)
					toastr.success('Thành công!','Tạo phí vận chuyển thành công!');
					$('.list-price-ship').append(json.html)
				}
			});
		}
	})

	$(document).on('click' ,'.update_price' ,function(){
		let _this = $(this);
		$('.index_update_price').hide();
		$('.view_price').show();
		_this.find('.view_price').hide();
		_this.find('input').show();
	})

	$(document).on('change' ,'.index_update_price' ,function(){
		let _this = $(this);
		let val = _this.val();
		val = val.replaceAll(".","");
		val = parseFloat(val);
		let id = _this.attr('data-id')
		let field = _this.attr('data-field')
		let form_URL = 'ajax/price/update_price';
		$.post(form_URL, {
			val : val, id: id, field: field
		},
		function(data){
			let json = JSON.parse(data);
			_this.hide();
			_this.siblings('.view_price').show();
			_this.siblings('.view_price').html(json.val);
		});	
	})

	$(document).on('click','.delete_price_ship', function(){
		let _this = $(this);
		let id =_this.attr('data-id')
		if(id.length > 0){
			swal({
				title: "Hãy chắc chắn rằng bạn muốn thực hiện thao tác này?",
				text: 'Xóa bản ghi này. Dữ liệu sẽ không thể khôi phục!',
				type: "warning",
				showCancelButton: true,
				confirmButtonColor: "#DD6B55",
				confirmButtonText: "Thực hiện!",
				cancelButtonText: "Hủy bỏ!",
				closeOnConfirm: false,
				closeOnCancel: false },
			function (isConfirm) {
				if (isConfirm) {
					var formURL = 'ajax/price/delete';
					$.post(formURL, {
						id: id},
						function(data){
							if(data == 0){
								sweet_error_alert('Có vấn đề xảy ra','Vui lòng thử lại')
							}else{
								swal("Xóa thành công!", "Bản ghi đã được xóa khỏi danh sách.", "success");
								$('#post-'+id).hide().remove()
							}
						});
				} else {
					swal("Hủy bỏ", "Thao tác bị hủy bỏ", "error");
				}
			});
		}
		else{
			sweet_error_alert('Thông báo từ hệ thống!', 'Bạn phải chọn 1 bản ghi để thực hiện chức năng này');
			return false;
		}
		return false;
	});
});