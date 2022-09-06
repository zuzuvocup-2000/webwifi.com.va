
$(document).ready(function(){
	$(document).on('click','.td-default span.text-danger', function(){


		let _this = $(this);
		let id = _this.parents('tr').attr('data-id');
		let lang = _this.parent('td').attr('data-lang');
		let $module = _this.parent('td').attr('data-module');
		var formURL = 'ajax/language/update_default_language';
		var parent  = _this.parent();
		_this.html(loading());
		
		setTimeout(function(){
			$.post(formURL, {
				id: id,module: $module, lang:lang},
				function(data){
					if(data == 0){
						sweet_error_alert('Có vấn đề xảy ra','Vui lòng thử lại')
					}else{
						$('.td-default ').not(_this).html('<span class="text-danger">No</span>');
						parent.html('<span class="text-navy">Yes</span>');
						location.reload();

					}
				});
		}, 500);


		return false;
	});
});
