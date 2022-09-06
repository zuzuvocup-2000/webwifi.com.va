// bat/tat form tim kiem nang cao 
$(document).on('click','.lta-btn',function(){
	let _this = $(this);
	let text = _this.text();
	if(text == 'Tìm kiếm nâng cao'){
		text = 'Thu gọn';
	}else{
		text = 'Tìm kiếm nâng cao';
	}
	_this.text(text);
	$('.form-search').find('.box-bill-advanced').toggle();
	return false;
});
$(document).on('click','.bill-note',function(){
    let _this = $(this);
    
    return false;
});

$(document).ready(function(){
	let daterange = $('input[name=daterange]').val();

	if(daterange != '' ){
		$('.form-advanced').trigger('click');
	}
});
$(document).on('click','.bill-onoffswitch', function(){
    let _this = $(this);
    let id = _this.parents('tr').attr('data-id');
    let field = _this.attr('data-field');
    let $module = _this.attr('data-module');
    var formURL = 'ajax/dashboard/update_field';
    
    $.post(formURL, {
        id: id,module: $module, field:field},
        function(data){
            if(data == 0){
                sweet_error_alert('Có vấn đề xảy ra','Vui lòng thử lại')
            }else{
                let json = JSON.parse(data);
                let text = (json.value == 1) ? true : false;
                _this.siblings('.text-status-bill').find('.text-small').removeClass('btn-primary')
                _this.siblings('.text-status-bill').find('.text-small').removeClass('btn-danger')
                if(text == true){
                    _this.find('input').prop('checked',true)
                    _this.siblings('.text-status-bill').find('.text-small').html('Thành công')
                    _this.siblings('.text-status-bill').find('.text-small').addClass('btn-primary')
                }else{
                    _this.find('input').prop('checked',false)
                    _this.siblings('.text-status-bill').find('.text-small').html('Chờ giao hàng')
                    _this.siblings('.text-status-bill').find('.text-small').addClass('btn-danger')
                }
            }
        });


    return false;
});