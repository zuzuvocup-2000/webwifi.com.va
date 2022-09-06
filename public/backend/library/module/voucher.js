
$(document).on('change','#toogle_readonly',function(){
	let _this = $(this);
	let attr = $('.voucherid').attr('name');
	if(_this.is(':checked') && typeof attr !== typeof undefined && attr !== false){
		$('.voucherid').removeAttr('readonly');
	}else{
		$('.voucherid').attr('readonly', true);
	}
});

$(document).on('click','.create-random-voucher',function(){
	let _this = $(this);
	let voucher = getRandomString(10);
	_this.siblings('.data-voucher').find('.voucherid').val(voucher)
	return false
});

if($('.create-random-voucher').length > 0 && voucherid == ''){
	$(document).ready(function(){
		$('.create-random-voucher').trigger('click')
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
	let form_URL = 'ajax/product/update_price_voucher';
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


