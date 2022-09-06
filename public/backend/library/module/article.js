var count = 0;

$(document).ready(function(){
	$(document).on('click','.delete-all', function(){
		let id = [];
		let _this = $(this);
		$('.checkbox-item:checked').each(function(){
			let _this = $(this);
		 	id.push(_this.val());
		});

		if(id.length > 0){
			swal({
				title: "Hãy chắc chắn rằng bạn muốn thực hiện thao tác này?",
				text: 'Xóa các Bài viết được chọn',
				type: "warning",
				showCancelButton: true,
				confirmButtonColor: "#DD6B55",
				confirmButtonText: "Thực hiện!",
				cancelButtonText: "Hủy bỏ!",
				closeOnConfirm: false,
				closeOnCancel: false },
			function (isConfirm) {
				if (isConfirm) {
					var formURL = 'ajax/dashboard/delete_all';
					$.post(formURL, {
						id: id, module: _this.attr('data-module')},
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

	$(document).on('click','.delete', function(){
		let _this = $(this);

		if(id.length > 0){
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
					var formURL = 'ajax/article/deleteArt';
					$.post(formURL, {
						id: id, module: _this.attr('data-module')},
						function(data){
							if(data == 0){
									sweet_error_alert('Có vấn đề xảy ra','Vui lòng thử lại')
								}else{
									swal("Xóa thành công!", "Bản ghi đã được xóa khỏi danh sách.", "success");
									window.location.href = BASE_URL+'backend/article/article/index';
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
$(document).on('click','.add-attr',function(){
	let _this = $(this);
	count++;
	render_attr();
})

function render_attr(){
	let html ='';
	var id = 'title_' + count;

	html = html + '<div class="ibox desc-more" style="opacity: 1;">';
        html = html + '<div class="ibox-title ui-sortable-handle">';
        	html = html + '<div class="uk-flex uk-flex-middle">';
                html = html + '<div class="col-lg-8">';
					html = html + '<input type="text" name="sub_content[title][]" class="form-control" value="" placeholder="Tiêu đề">';
				html = html + '</div>';
				html = html + '<div class="col-lg-4">';
					html = html + '<div class="uk-flex uk-flex-middle uk-flex-space-between">';
						html = html + '<a href="" title="" data-target="'+id+'" class="uploadMultiImage">Upload hình ảnh</a>';
		                html = html + '<div class="ibox-tools">';
		                    html = html + '<a class="collapse-link ui-sortable">';
		                        html = html + '<i class="fa fa-chevron-up"></i>';
		                    html = html + '</a>';
		                    html = html + '<a class="close-link">';
		                        html = html + '<i class="fa fa-times"></i>';
		                    html = html + '</a>';
		                html = html + '</div>';
					html = html + '</div>';
				html = html + '</div>';
        	html = html + '</div>';
        html = html + '</div>';
        html = html + '<div class="ibox-content" style="">';
        	html = html + '<div class="row">';
                html = html + '<div class="col-lg-12" >';
                	html = html + '<textarea name="sub_content[description][]" class="form-control ck-editor" id="'+id+'" placeholder="Mô tả"></textarea>';
				html = html + '</div>';
			html = html + '</div>	';
        html = html + '</div>';
    html = html + '</div>';

	$('.attr-more').prepend(html);
	ckeditor5(id);
}