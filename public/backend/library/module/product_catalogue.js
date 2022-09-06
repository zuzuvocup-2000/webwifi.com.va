$(document).on('click','.image-product-edit', function(){
    let type = 'Images';
    let finder = new CKFinder();
    finder.resourceType = type;
    let _this = $(this);
    let id = _this.parents('tr').attr('data-id')
    finder.selectActionFunction = function( fileUrl, data ) {
        fileUrl =  fileUrl.replace(BASE_URL, "/");
        _this.find('img').attr('src', fileUrl)
        $.post('ajax/product/change_image', {
			id: id,image :fileUrl},
		function(data){
			let response = JSON.parse(data);
			if(response.code == 10){
				toastr.success(response.message);
			}else {
				if(response.code == 404 || response.code == 500 ){
					toastr.error(response.message);
				}else{
					toastr.error('Có lỗi xảy ra! Xin vui lòng thử lại');
				}
			}
		});
    }
    finder.popup();
});




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
	let id = _this.attr('data-id')
	let field = _this.attr('data-field')
	let form_URL = 'ajax/product/update_price';
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

$(document).on('click','.nd_accordion tr .extend',function(){
	let _this = $(this);
	let extend = _this.attr('data-extend');
	let id = _this.parents('tr').attr('data-id');
	let module = _this.parents('tr').attr('data-module');
	$.post('ajax/product/get_all_product', {
			module :module,id :id, type: extend},
		function(data){
			let response = JSON.parse(data);
			if(response.code == 10){
				if(extend == 'plus'){
					_this.parents('tr').after(response.html)
					_this.attr('data-extend','minus');
					_this.html('<i class="fa fa-minus" aria-hidden="true"></i>');
					if($(this).hasClass('hidden')){
						$(this).removeClass('hidden');
					}
					toastr.success('Lấy dữ liệu danh mục thành công!');
				}
				if(extend == 'minus'){
					$('.remove-table-child[data-catalogueid='+id+']').remove()
					_this.attr('data-extend','plus');
					_this.html('<i class="fa fa-plus" aria-hidden="true"></i>');
					if($(this).hasClass('hidden') == false){
						$(this).addClass('hidden');
					}
					toastr.success('Thu gọn dữ liệu danh mục thành công!');
				}
			}else{
				if(response.code != 10){
					toastr.error('Danh mục không tồn tại bất kì dữ liệu nào!');
				}
			}
		});
});

function sum(a = 0 ,b = 0){
	return parseFloat(a) + parseFloat(b);
}