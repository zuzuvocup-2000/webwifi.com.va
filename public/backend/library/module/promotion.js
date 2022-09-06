
$(document).on('change','#toogle_readonly',function(){
	let _this = $(this);
	let attr = $('.promotionid').attr('name');
	if(_this.is(':checked') && typeof attr !== typeof undefined && attr !== false){
		$('.promotionid').removeAttr('readonly');
	}else{
		$('.promotionid').attr('readonly', true);
	}
});

$(document).on('click','.create-random-promotion',function(){
	let _this = $(this);
	let promotion = getRandomString(10);
	_this.siblings('.data-promotion').find('.promotionid').val(promotion)
	return false
});

if($('.create-random-promotion').length > 0 && promotionid == ''){
	$(document).ready(function(){
		$('.create-random-promotion').trigger('click')
	})
}

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
	let form_URL = 'ajax/promotion/update_price_promotion';
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

function getRandomString(length) {
	var randomChars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
	var result = '';
	for ( var i = 0; i < length; i++ ) {
	result += randomChars. charAt(Math. floor(Math. random() * randomChars. length));
	}
	return result;
}

$(document).on('click','.login-onoffswitch', function(){
	let _this = $(this);
	let id = _this.parents('tr').attr('data-id');
	let field = _this.attr('data-field');
	let $module = _this.attr('data-module');
	var formURL = 'ajax/promotion/update_field_login';
	
	$.post(formURL, {
		id: id,module: $module, field:field},
		function(data){
			if(data == 0){
				sweet_error_alert('Có vấn đề xảy ra','Vui lòng thử lại')
			}else{
				$('.login-onoffswitch').find('input').prop('checked',false)
				_this.find('input').prop('checked',true)
			}
		});


	return false;
});