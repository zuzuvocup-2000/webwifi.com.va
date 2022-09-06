$(document).ready(function(){
	
	$(document).on('click','.delete-image', function(){
		$('#btn-submit-slide').addClass('js-btn-update');
		return false;
	});

	$(document).on('click','.delete-all', function(){
		let id = [];
		$('.checkbox-item:checked').each(function(){
			let _this = $(this);
		 	id.push(_this.val());
		});
		if(id.length > 0){
			swal({
				title: "Hãy chắc chắn rằng bạn muốn thực hiện thao tác này?",
				text: 'Xóa các bản ghi được chọn',
				type: "warning",
				showCancelButton: true,
				confirmButtonColor: "#DD6B55",
				confirmButtonText: "Thực hiện!",
				cancelButtonText: "Hủy bỏ!",
				closeOnConfirm: false,
				closeOnCancel: false },
			function (isConfirm) {
				if (isConfirm) {
					var formURL = 'ajax/slide/delete_all';
					$.post(formURL, {
						id: id,},
						function(data){
							if(data == 0){
									sweet_error_alert('Có vấn đề xảy ra','Vui lòng thử lại')
								}else{
									for(let i = 0; i < id.length; i++){
										$('#post-'+id[i]).hide().remove()				
									}
									swal("Xóa thành công!", "Các bản ghi đã được xóa khỏi danh sách.", "success");
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

	$(document).on('click','.js-btn-delete', function(){
		let id = $(this).attr('data-id')
		if(id.length > 0){
			swal({
				title: "Hãy chắc chắn rằng bạn muốn thực hiện thao tác này?",
				text: 'Xóa bản ghi được chọn',
				type: "warning",
				showCancelButton: true,
				confirmButtonColor: "#DD6B55",
				confirmButtonText: "Thực hiện!",
				cancelButtonText: "Hủy bỏ!",
				closeOnConfirm: false,
				closeOnCancel: false },
			function (isConfirm) {
				if (isConfirm) {
					var formURL = 'ajax/slide/delete_one';
					$.post(formURL, {
						id: id,},
						function(data){
							if(data == 0){
									sweet_error_alert('Có vấn đề xảy ra','Vui lòng thử lại')
								}else{
									$('#post-'+id).hide().remove()				
									swal("Xóa thành công!", "Các bản ghi đã được xóa khỏi danh sách.", "success");
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

	$(document).on('click','.show-image', function(){
		let _this = $(this)
		get_data_image(_this)
		return false;
	});

	$(document).on('click','.icon-change-image.left', function(){
		let _this = $(this)
		let _class = _this.attr('data-target');
		get_data_image($(_class).prev().find('.show-image'))
		return false;
	});

	$(document).on('click','.icon-change-image.right', function(){
		let _this = $(this)
		let _class = _this.attr('data-target');
		get_data_image($(_class).next().find('.show-image'))
		return false;
	});

	$(document).on('submit','.form-horizontal-banner', function(){
		let _this = $(this);
		let param = _this.serializeArray()
		let _class = _this.attr('data-target')
		var formURL = 'ajax/slide/create_data_image';
		$.post(formURL, {
			param: param
		},
		function(data){
			$(_class).find('.value-data-banner').val(data)
			toastr.success('Khởi tạo dữ liệu ảnh thành công','Thành công!');

		});
		return false;
	})

	function get_data_image(_this){
		let image = _this.parents('.ui-state-default').find('.value-img-banner').val()
		let data = _this.parents('.ui-state-default').find('.value-data-banner').val()
		console.log(data)
		let _class = _this.attr('data-class')
		
		$('.icon-change-image').removeAttr('disabled')
		if($(_class).is(':first-child') == true){
			$('.icon-change-image.left').attr('disabled', 'disabled')
		}
		if($(_class).is(':last-child') == true){
			$('.icon-change-image.right').attr('disabled', 'disabled')
		}
		$('.icon-change-image').attr('data-target' , _class)
		$('.form-horizontal-banner').attr('data-target' , _class)
		$('.form-horizontal-banner')[0].reset();
		var formURL = 'ajax/slide/open_modal';
		$('.file_general_detail').html('')
		$.post(formURL, {
			image: image,data: data},
		function(data){
			let json = JSON.parse(data)
			var ext = json.image.split('.').pop();
			if(ext == 'mp4'){
				$('.video-image').append('<video  controls><source src="'+json.image+'" type="video/mp4"></video>')
			}else{
				$('.details-image').attr('src', json.image)
				$('.details-image').parents('.va-thumb-1-1').show()
			}
			for (let i = 0; i < json.info.length; i++) {
				$('.'+json.info[i].name).html(json.info[i].value)
			}
			$('#attachment-details-two-column-title').val(json.data.title)
			$('#attachment-details-two-column-alt-text').val(json.data.alt)
			$('#attachment-details-two-column-canonical').val(json.data.canonical)
			$('#attachment-details-two-column-description').val(json.data.description)
			$('#attachment-details-two-column-caption').val(json.data.content)
		});
	}
	
});