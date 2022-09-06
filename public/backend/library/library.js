$(document).ready(function(){
	$(document).on('click','.clone-btn', function(){
		let _this = $(this);
		let quantity = parseInt($('#quantity').val());
		let id = [];
		$('.checkbox-item:checked').each(function(){
			let _this = $(this);
		 	id.push(_this.val());
		});
		if(quantity > 0){
			if(id.length > 0){
				swal({
					title: "Hãy chắc chắn rằng bạn muốn thực hiện thao tác này?",
					text: 'Sao chép các bản ghi được chọn',
					type: "warning",
					showCancelButton: true,
					confirmButtonColor: "#DD6B55",
					confirmButtonText: "Thực hiện!",
					cancelButtonText: "Hủy bỏ!",
					closeOnConfirm: false,
					closeOnCancel: false },
				function (isConfirm) {
					if (isConfirm) {
						var formURL = 'ajax/dashboard/clone_all';
						$.post(formURL, {
							id: id, module: _this.attr('data-module'), quantity: $('#quantity').val()},
							function(data){
								if(data == 0){
									sweet_error_alert('Có vấn đề xảy ra','Vui lòng thử lại')
								}else{
									swal("Sao chép thành công!", "Các bản ghi đã được sao chép.", "success");
									window.location.reload()
								}
							});
					} else {
						swal("Hủy bỏ", "Thao tác bị hủy bỏ", "error");
					}
				});
			}
			else{
				sweet_error_alert('Thông báo từ hệ thống!', 'Bạn phải chọn 1 bản ghi để thực hiện chức năng này');
			}
		}else{
			sweet_error_alert('Thông báo từ hệ thống!', 'Bạn phải nhập số lượng để thực hiện chức năng này');
		}
		return false;
	});
	
	$(document).ready(function(){
		let star_val = $('.data-rate').val()
		$("input[name=data-rate][value=" + star_val + "]").attr('checked', 'checked');
	})
	jQuery(document).ready(function() {
	  	jQuery("time.timeago").timeago();
	});
	$( function() {
		$( ".sortui" ).sortable();
		$( ".sortui" ).disableSelection();
		$( "#sortable" ).sortable();
		$( "#sortable" ).disableSelection();
		$( ".ui-sortable" ).sortable();
		$( ".ui-sortable" ).disableSelection();
		$( ".sort-modal" ).sortable();
		$( ".sort-modal" ).disableSelection();
	});
	if($('input[name="daterange"]').length > 0){
 		$('input[name="daterange"]').daterangepicker();
	}
	if($('.tagsinput').length > 0){
		$('.tagsinput').tagsinput({
	        tagClass: 'label label-primary',
	        confirmKeys: [13, 188],
	        cancelConfirmKeysOnEmpty: false,
	    });
	}

	$(document).on('click','.ui-state-default .thumb .fa-trash', function(){
		let _this = $(this);
		_this.parents('.ui-state-default').remove();
		if($('#sortable li').length == 0){
			$('.click-to-upload').show();
   		 	$('.upload-list').hide();
		}
	});

	$(document).ready(function(){
	
	    const $button = document.querySelector('.simplepicker');
	    if($button != null){
			let simplepicker = new SimplePicker({
		      	zIndex: 10
		    });

		    $button.addEventListener('click', (e) => {
		      simplepicker.open();
		    });

		    // $eventLog.innerHTML += '\n\n';
		    simplepicker.on('submit', (date, readableDate) => {
		      	let form_URL = 'ajax/dashboard/get_time_simple';
				$.post(form_URL, {
					time : readableDate
				},
				function(data){
					$('.simplepicker').val(data)
				});
		    });
	    }
		
	})

	$(document).on('change','input[name=data-rate]', function(){
		let _this = $(this);
		let val = $("input[name=data-rate]:checked").val()
		$('.data-rate').val(val)
	});

	$(document).on('change','.select_module_comment', function(){
		let _this = $(this);
		let module = _this.val()
		let language = _this.attr('data-lang')
		let form_URL = 'ajax/dashboard/get_canonical_comment';
		$.post(form_URL, {
			module : module,language:language
		},
		function(data){
			let json = JSON.parse(data);
			let html = '<option value="0">-- Chọn bài viết --</option>';
			for (var i = 0; i < json.length; i++) {
				if(json[i].canonical == canonical_comment){
					html = html+'<option value="'+json[i].canonical+'" selected>'+json[i].title+'</option>';
				}else{
					html = html+'<option value="'+json[i].canonical+'">'+json[i].title+'</option>';
				}
			}
			$('.select_url_comment').html(html)
		});	

	});
	if(typeof(moduleid_comment) != 'undefined' && moduleid_comment != ''){
		$('.select_module_comment').val(moduleid_comment).trigger('change', [{'trigger':true}]);
	}
	


	$(document).on('click','.translate_ajax', function(){
		let _this = $(this);
		let module = _this.attr('data-module')
		let lang = _this.attr('data-lang')
		let title = _this.attr('data-title')
		let id = _this.attr('data-id')
		let form_URL = 'ajax/dashboard/translate_location';
		$.post(form_URL, {
			module : module, lang: lang, id: id, title :title
		},
		function(data){
			let json = JSON.parse(data);
			$('#va_translate').attr('data-id',json.id)
			$('#va_translate').attr('data-module',json.module)
			$('#va_translate').attr('data-lang',json.lang)
			$('#title_first').val(json.title)
			$('#title_translate').val(json.title_translate)
		});	
		return false;
		
	});

	$('#va_translate').on("submit", function(event) {
        event.preventDefault();
		let id = $('#va_translate').attr('data-id')
		let module = $('#va_translate').attr('data-module')
		let lang = $('#va_translate').attr('data-lang')
		let title = $('#title_translate').val()
        if (title == "") {
            alert("Vui lòng nhập vào trường Tiêu đề!");
        } else {
            let form_URL = 'ajax/dashboard/translate';
        	$.post(form_URL, {
				id : id, module: module, lang: lang, title: title
			},
			function(data){
				$('#va_translate')[0].reset();
                location.reload();
			});	
        }
    });

	$('.datetimepicker').datepicker({
		todayBtn: "linked",
		keyboardNavigation: false,
		forceParse: false,
		calendarWeeks: true,
		autoclose: true,
		dateFormat: "yy-mm-dd"
	});

	$(document).on('click','.va-option-input', function(){
		let _this = $(this);
		let catalogueid = _this.parents('.wrap-catalogue-widget').attr('data-id')
		let count = _this.parents('.wrap-catalogue-widget').find('.va-option-input:checked').length;
		if(count == 1){
			let form_URL = 'ajax/dashboard/select_widget';
			let select = _this.parents('.wrap-catalogue-widget').find('.va-option-input:checked');
			let html = select.attr('data-html')
			let css = select.attr('data-css')
			let script = select.attr('data-script')
			let title = select.attr('data-title')
			let keyword = select.attr('data-keyword')
        	$.post(form_URL, {
				catalogueid : catalogueid, html: html, css: css, script: script, title: title, keyword: keyword
			},
			function(data){
				
			});	
		}else if(count == 0){
			let delete_URL = 'ajax/dashboard/delete_widget';
			$.post(delete_URL, {
				catalogueid : catalogueid
			},
			function(data){
				
			});	
		}else{
			_this.prop("checked", false);
		    toastr.warning('Chỉ chọn duy nhất 1 mục trong nhóm!','Xảy ra lỗi!');
		}
	});

	$(document).ready(function(){
		let data_0 = $('#insert_general').attr('data-max-0');
		for(let i = 1; i <= data_0; i++ ){
			$('.render_num0').append(0);
		}
	})

	$(document).on('keyup','#suffix', function(){
		let suffix = $(this).val();
		$(this).parents().find('.render_suffix').html(suffix);
	});
	$(document).on('keyup','#prefix', function(){
		let prefix = $(this).val();
		$(this).parents().find('.render_prefix').html(prefix);
	});

	$('#insert_general').on("submit", function(event) {
        event.preventDefault();
		let data_0 = $('#insert_general').attr('data-max-0');
        let suffix = $('#suffix').val();
        let prefix = $('#prefix').val();
        if (suffix == "") {
            alert("Vui lòng nhập vào trường Tiền tố!");
        } else if (prefix == '') {
            alert("Vui lòng nhập vào trường Hậu tố!");
        } else {
            let form_URL = 'ajax/product/general_id';
        	$.post(form_URL, {
				suffix : suffix, prefix: prefix, data_0: data_0, module: _module
			},
			function(data){
				$('#insert_general')[0].reset();
                location.reload();
			});	
        }
    });

	if($('.select2').length){
		$('.select2').select2();
	}

	if($('.selectMultiple').length){
		$('.selectMultiple').each(function(){
			let _this = $(this);
			let select = _this.attr('data-select');		
			let module = _this.attr('data-module');
			let join = _this.attr('data-join');
			setTimeout(function(){
				if(catalogue != ''){
					$.post('ajax/dashboard/pre_select2', {
						value: catalogue, module: module, select: select, join: join,},
						function(data){
							let json = JSON.parse(data);
							if(json.items!='undefined' && json.items.length){
								for(let i = 0; i< json.items.length; i++){
									var option = new Option(json.items[i].text, json.items[i].id, true, true);
									_this.append(option).trigger('change');
								}
							}
						});
				}
			}, 10);

			get_select2(_this);
		});
	}

	$(document).on('change','.select2_panel', function(){
		let _this = $(this);
		let val  = _this.val();
		var module_explode = val.split("_");
		$('.selectMultiplePanel').attr('data-join', module_explode[0]+'_translate');
		$('.selectMultiplePanel').attr('data-module', val);
		$(".selectMultiplePanel").empty();
		if($('.selectMultiplePanel').length){
			$('.selectMultiplePanel').each(function(){
				let _this = $(this);
				let select = _this.attr('data-select');		
				let module = _this.attr('data-module');
				let join = _this.attr('data-join');
				let language = _this.attr('data-lang');
				get_select2_multiple(_this,language);
			});
		}
		return false;
	});

	if($('.selectMultiplePanel').length){
		$('.selectMultiplePanel').each(function(){
			let _this = $(this);
			$('.select2_panel').trigger('change');
			let select = _this.attr('data-select');		
			let module = _this.attr('data-module');
			let join = _this.attr('data-join');
			let language = _this.attr('data-lang');
			setTimeout(function(){
				if(catalogue != ''){
					$.post('ajax/dashboard/pre_select2', {
						value: catalogue, module: module, select: select, join: join,language: language},
						function(data){
							let json = JSON.parse(data);
							if(json.items!='undefined' && json.items.length){
								for(let i = 0; i< json.items.length; i++){
									var option = new Option(json.items[i].text, json.items[i].id, true, true);
									_this.append(option).trigger('change');
								}
							}
						});
				}
			}, 10);

			get_select2_multiple(_this);
		});
	}

	$('.ck-editor').each(function(){
		ckeditor5($(this).attr('id'));
	});

	$(document).on('click','.edit-seo', function(){
		$('.seo-group').toggleClass('hidden');
		return false;
	});

	$(document).ready(function(){
		$('.int').trigger('change')
	})

	$(document).on('click','.float, .int',function(){
		let data = $(this).val();
		if(data == 0){
			$(this).val('');
		}
	});
	$(document).on('keydown','.float, .int',function(e){
		let data = $(this).val();
		if(data == 0){
			let unicode=e.keyCode || e.which;
			if(unicode != 190){
				$(this).val('');
			}
		}
	});

	$(document).on('change keyup blur','.int',function(){
		let data = $(this).val();
		if(data == '' ){
			$(this).val('0');
			return false;
		}
		data = data.replace(/\./gi, "");
		$(this).val(addCommas(data));
		data = data.replace(/\./gi, "");
		if(isNaN(data)){
			$(this).val('0');
			return false;
		}
	});
	
	$(document).on('keyup', '.title', function(){
		let _this = $(this);
		let metaTitle = _this.val();
		get_catalogue(slug(metaTitle));
		let totalCharacter = metaTitle.length;
		console.log(totalCharacter);
		if(totalCharacter > 70){
			$('.meta-title').addClass('input-error');
		}else{
			$('.meta-title').removeClass('input-error');
		}
		$('.g-title').text(metaTitle);
		$('.meta-title').val(metaTitle);

	});

	$(document).on('change', '.get_catalogue', function(){
		let _this = $(this);
		let val = $('.title').val();
		let id = _this.val();
		let module = _this.attr('data-module')
		if(_this.val() == 0){
			val = slug(val);
			$('.canonical').val(val)
			$('.g-link').text(BASE_URL + val + '.html');
		}else{
			$.post('ajax/dashboard/get_catalogue', {
				id: id, module: module
			},
			function(data){
				val = slug(val)
				let new_text = data+'/'+val
				$('.canonical').val(new_text)
				$('.g-link').text(BASE_URL + new_text + '.html');
			});
		}
	})
	
	$(document).on('keyup','.canonical', function(){
		let _this = $(this);
		_this.attr('data-flag', '1');
		let slugTitle = slug(_this.val());
		$('.g-link').text(BASE_URL + slugTitle + '.html');
	});
	
	$(document).on('keyup change','.meta-title', function(){
		let _this = $(this);
		let totalCharacter = _this.val().length;
		$('#titleCount').text(totalCharacter);
		if(totalCharacter > 70){
			_this.addClass('input-error');
		}else{
			_this.removeClass('input-error');
		}
		$('.g-title').text(_this.val());
	});
	
	

	
	$(document).on('keyup change','.meta-description', function(){
		let _this = $(this);
		let totalCharacter = _this.val().length;
		$('#descriptionCount').text(totalCharacter);
		if(totalCharacter > 320){
			_this.addClass('input-error');
		}else{
			_this.removeClass('input-error');
		}
		$('.g-description').text(_this.val());
	});




	

	$(document).on('change', '#city', function(e, data){
		let _this = $(this);
		let id = _this.val();
		let param = {
			'id' : id,
			'text' : '[Chọn Quận/Huyện]',
			'table' : 'vn_district',
			'trigger_district': (typeof(data) != 'undefined') ? true : false,
			'where' : {'provinceid' : id},
			'select' : 'districtid as id, name',
			'object' : '#district',
		};
		get_location(param);
	});

	if(typeof(cityid) != 'undefined' && cityid != ''){
		$('#city').val(cityid).trigger('change', [{'trigger':true}]);
	}

	$(document).on('change', '#district', function(){
		let _this = $(this);
		let id = _this.val();
		let param = {
			'id' : id,
			'text' : '[Chọn Phường/Xã]',
			'table' : 'vn_ward',
			'where' : {'districtid' : id},
			'select' : 'wardid as id, name',
			'object' : '#ward',
		};
		get_location(param);
	});

	/* UPDATE ORDER */
	$(document).on('change', '.sort-order',function(){
		let _this = $(this);
		let id = [_this.attr('data-id')];

		let $module = _this.attr('data-module');
		let value = _this.val();
		let formURL = 'ajax/dashboard/update_by_field'
		setTimeout(function(){
			$.post(formURL, {
				id: id,module: $module, value:value, field : 'order'},
				function(data){
					
				});
		}, 200);


	});

	/* UPDATE STATUS */

	$(document).on('click','.td-status span', function(){
		let _this = $(this);
		let id = _this.parents('tr').attr('data-id');
		let field = _this.parent('td').attr('data-field');
		let $module = _this.parent('td').attr('data-module');
		var formURL = 'ajax/dashboard/update_field';
		_this.html(loading());
		
		setTimeout(function(){
			$.post(formURL, {
				id: id,module: $module, field:field},
				function(data){
					if(data == 0){
						sweet_error_alert('Có vấn đề xảy ra','Vui lòng thử lại')
					}else{
						let json = JSON.parse(data);
						let text = (json.value == 1) ? '<span class="text-success">Active</span>' : '<span class="text-danger">Deactive</span>';
						_this.parent().html(text);
					}
				});
		}, 500);


		return false;
	});
	$(document).on('click','.publishonoffswitch', function(){
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
					if(text == true){
						_this.find('input').prop('checked',true)
					}else{
						_this.find('input').prop('checked',false)
					}
				}
			});


		return false;
	});

	

	$(document).on('click','.status', function(){
		let _this = $(this);
		let param = {
			'module' : _this.attr('data-module'),
			'value' : _this.attr('data-value'),
			'field' : _this.attr('data-field'),
		};

		let id = [];
		$('.checkbox-item:checked').each(function(){
			let _this = $(this);
		 	id.push(_this.val());
		});

		if(id.length > 0){
			swal({
				title: "Hãy chắc chắn rằng bạn muốn thực hiện thao tác này?",
				text: _this.attr('data-title'),
				type: "warning",
				showCancelButton: true,
				confirmButtonColor: "#DD6B55",
				confirmButtonText: "Thực hiện!",
				cancelButtonText: "Hủy bỏ!",
				closeOnConfirm: false,
				closeOnCancel: false },
			function (isConfirm) {
				if (isConfirm) {
					var formURL = 'ajax/dashboard/update_by_field';
					$.post(formURL, {
						id: id,module: param.module, field:param.field, value:param.value},
						function(data){
							if(data == 0){
									sweet_error_alert('Có vấn đề xảy ra','Vui lòng thử lại')
								}else{
									for(let i = 0; i < id.length; i++){
										let text = (param.value == 1) ? '<span class="text-success">Active</span>' : '<span class="text-danger">Deactive</span>';
										$('#post-'+id[i]).find('.td-status').html(text);			
									}
									swal("Thành công!", "Thao tác thực hiện thành công!", "success");
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

	/* CHECKBOX - CHECKALL */
	$(document).on('click','.label-checkboxitem',function(){
		let _this = $(this);
		_this.parent().find('.checkbox-item').trigger('click');
		check(_this);
		change_background(_this);
		check_item_all(_this);
		check_setting();
	});

	$(document).on('click','.labelCheckAll',function(){
		let _this = $(this);
		_this.siblings('input').trigger('click');
		check(_this);
		checkall(_this);
		change_background();
		check_setting();
	});
});

$(document).on('click','.open-window', function(){
	let _this = $(this);
	let target = _this.attr('target');
	js_open_windown(this, _this, target);
	return false;
});

function js_open_windown($this, _this, target){
	let _w = _this.attr('data-width')
	let _h = _this.attr('data-height')
	let h  = 0;
	let w = 0;
	let name = '';

	if(target != 'undefined'){
		name = target;
	}else{
		name = 'chrome';
	}
	if(typeof(_w) == 'undefined' || typeof(_h) == 'undefined' ){
		 h = screen.availHeight;
		 w = screen.availWidth-100;
	}else{
		 h = _h;
		 w = _w;
	}

	popupCenter($this.href, name, w, h);
	// window.open($this.href, 'chrome', 'top='+h*2/100+', left='+w*5/100+', width='+w*90/100+',height='+h*90/100);
	return false;
}
function popupCenter (url ,title, w, h, blank){
    // Fixes dual-screen position                             Most browsers      Firefox
    const dualScreenLeft = window.screenLeft !==  undefined ? window.screenLeft : window.screenX;
    const dualScreenTop = window.screenTop !==  undefined   ? window.screenTop  : window.screenY;

    const width = window.innerWidth ? window.innerWidth : document.documentElement.clientWidth ? document.documentElement.clientWidth : screen.width;
    const height = window.innerHeight ? window.innerHeight : document.documentElement.clientHeight ? document.documentElement.clientHeight : screen.height;

    const systemZoom = width / window.screen.availWidth;
    const left = (width - w) / 2 / systemZoom + dualScreenLeft
    const top = (height - h) / 2 / systemZoom + dualScreenTop
    const newWindow = window.open(url, title,
      `
      scrollbars=yes,
      width=${w / systemZoom},
      height=${h / systemZoom},
      top=${top},
      left=${left}
      `
    )

    if (window.focus) newWindow.focus();
}

function get_location(param){
	if(districtid == '' || param.trigger_district == false) districtid = 0;
	if(wardid == ''  || param.trigger_ward == false) wardid = 0;

	let formURL = 'ajax/dashboard/get_location';
	$.post(formURL, {
		param: param},
		function(data){
			let json = JSON.parse(data);
			if(param.object == '#district'){
				$(param.object).html(json.html).val(districtid).trigger('change');
			}else if(param.object == '#ward'){
				$(param.object).html(json.html).val(wardid);
			}
			
		});
}

function get_catalogue(val = ''){
	let data ='';
	val = slug(val);
	let id = $('.get_catalogue').val();
	let module = $('.get_catalogue').attr('data-module');
	let canonical = $('.canonical');
	if(id == 0 || id == undefined){
		val = slug(val)
		$('.g-link').text(BASE_URL + val + '.html');
		$('.canonical').val(val)
	}else{
		$.post('ajax/dashboard/get_catalogue', {
			id: id, module: module
		},
		function(data){
			val = slug(val)
			let new_text = data+'/'+val
			$('.canonical').val(new_text)
			$('.g-link').text(BASE_URL + new_text + '.html');
			
		});
	}


}


/* CHECKBOX */
function check(object){
	if(object.hasClass('checked')){
		object.removeClass('checked');
	}else{
		object.addClass('checked');
	}
}



function checkall(_this){
	let table = _this.parents('table');
	if($('#checkbox-all').length){
		if(table.find('#checkbox-all').prop('checked')){
			table.find('.checkbox-item').prop('checked', true);
			table.find('.label-checkboxitem').addClass('checked');
			
		}
		else{
			table.find('.checkbox-item').prop('checked', false);
			table.find('.label-checkboxitem').removeClass('checked');
		}
	}
	check_setting();
}

function check_item_all(_this){
	let table = _this.parents('table');
	if(table.find('.checkbox-item').length) {
		if(table.find('.checkbox-item:checked').length == table.find('.checkbox-item').length) {
			table.find('#checkbox-all').prop('checked', true);
			table.find('.labelCheckAll').addClass('checked');
		}
		else{
			table.find('#checkbox-all').prop('checked', false);
			table.find('.labelCheckAll').removeClass('checked');
		}
	}
}

function check_setting(){
	if($('.checkbox-item').length) {
		if($('.checkbox-item:checked').length > 0) {
			$('.fa-cog').addClass('text-pink');
		}
		else{
			$('.fa-cog').removeClass('text-pink');
		}
	}
}

function check_setting(){
	if($('.checkbox-item').length) {
		if($('.checkbox-item:checked').length > 0) {
			$('.fa-wrench').addClass('text-pink');
		}
		else{
			$('.fa-wrench').removeClass('text-pink');
		}
	}
}

function change_background() {
	$('.checkbox-item').each(function() {
		if($(this).is(':checked')) {
			$(this).parents('tr').addClass('bg-active');
		}else {
			$(this).parents('tr').removeClass('bg-active');
		}
	});
}

function pre(param){
}

function loading(){
	let loading = '<div class="spiner-example">';
       loading = loading + ' <div class="sk-spinner sk-spinner-wave">'
           loading = loading + ' <div class="sk-rect1"></div>'
           loading = loading + ' <div class="sk-rect2"></div>'
           loading = loading + ' <div class="sk-rect3"></div>'
            loading = loading + '<div class="sk-rect4"></div>'
            loading = loading + '<div class="sk-rect5"></div>'
        loading = loading + '</div>'
    loading = loading + '</div>'

    return loading;
}

function sweet_error_alert(title, message){
	swal({
		title: title,
		text: message
	});
}

function slug(title){
	title = cnvVi(title);
	return title;
}


function cnvVi(str) {
	str = str.toLowerCase(); // chuyen ve ki tu biet thuong
	str = str.replace(/à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ắ|ặ|ẳ|ẵ/g, "a");
	str = str.replace(/è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ/g, "e");
	str = str.replace(/ì|í|ị|ỉ|ĩ/g, "i");
	str = str.replace(/ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ/g, "o");
	str = str.replace(/ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ/g, "u");
	str = str.replace(/ỳ|ý|ỵ|ỷ|ỹ/g, "y");
	str = str.replace(/đ/g, "d");
	str = str.replace(/!|@|%|\^|\*|\(|\)|\+|\=|\<|\>|\?|,|\.|\:|\;|\'|\–| |\"|\&|\#|\[|\]|\\|\/|~|$|_/g, "-");
	str = str.replace(/-+-/g, "-");
	str = str.replace(/^\-+|\-+$/g, "");
	return str;
}
function replace(Str=''){
	if(Str==''){
		return '';
	}else{
		Str = Str.replace(/\./gi, "");
		return Str;
	}
}

function addCommas(nStr){
	nStr = String(nStr);
	nStr = nStr.replace(/\./gi, "");
	let str ='';
	for (i = nStr.length; i > 0; i -= 3){
		a = ( (i-3) < 0 ) ? 0 : (i-3); 
		str= nStr.slice(a,i) + '.' + str; 
	}
	str= str.slice(0,str.length-1); 
	return str;
}

function selectMultipe(object, select="title"){
	let condition =  object.attr('data-condition');
	let title = object.attr('data-title');
	let module = object.attr('data-module');
	let key = object.attr('data-key');
	object.select2({
		minimumInputLength: 2,
		placeholder: title,
			ajax: {
				url: 'ajax/dashboard/get_multiple',
				type: 'POST',
				dataType: 'json',
				deley: 250,
				data: function (params) {
					return {
						locationVal: params.term,
						module:module,key:key, select:select, condition:condition,
					};
				},
				processResults: function (data) {
					return {
						results: $.map(data, function(obj, i){
							return obj
						})
					}
					
				},
				cache: true,
			}
	});
}

function getDataMultiple(object, data, select="title"){
	let condition =  object.attr('data-condition');
	let title = object.attr('data-title');
	let module = object.attr('data-module');
	let key = object.attr('data-key');
	setTimeout(function(){
		if(catalogue != ''){
			$.post('ajax/dashboard/getDataMultiple', {
				condition: condition, title: title, module: module, select: select,key:key, data : data},
				function(data){
					let json = JSON.parse(data);
					if(json !='undefined' && json.length){
						for(let i = 0; i< json.length; i++){
							var option = new Option(json[i].title, json[i].id, true, true);
							object.append(option);
						}
					}
				});
		}
	}, 10);

	get_select2_multiple(object);
}

function getDataPanel(object, data, select="title"){
	let condition =  object.attr('data-condition');
	let title = object.attr('data-title');
	let module = object.attr('data-module');
	let key = object.attr('data-key');
	setTimeout(function(){
		if(catalogue != ''){
			$.post('ajax/dashboard/getDataMultiple', {
				condition: condition, title: title, module: module, select: select,key:key, data : data},
				function(data){
					let json = JSON.parse(data);
					if(json !='undefined' && json.length){
						for(let i = 0; i< json.length; i++){
							var option = new Option(json[i].title, json[i].id, true, true);
							object.append(option);
						}
					}
				});
		}
	}, 10);

	get_select2_panel(object);
}

function get_select2(object,lang){
	let module = object.attr('data-module');
	let select = object.attr('data-select');
	let join = object.attr('data-join');
	$('.selectMultiple').select2({
		minimumInputLength: 2,
		placeholder: 'Nhập tối thiểu 2 ký tự để tìm kiếm',
			ajax: {
				url: 'ajax/dashboard/get_select2',
				type: 'POST',
				dataType: 'json',
				deley: 250,
				data: function (params) {
					return {
						locationVal: params.term,
						module:module,
						select: select,
						join: join,

					};
				},
				processResults: function (data) {
					return {
						results: $.map(data, function(obj, i){
							return obj
						})
					}
					
				},
				cache: true,
			}
	});
	// $('.selectAttribute').select2({
	// 	minimumInputLength: 2,
	// 	placeholder: 'Nhập tối thiểu 2 ký tự để tìm kiếm',
	// 		ajax: {
	// 			url: 'ajax/dashboard/get_select2',
	// 			type: 'POST',
	// 			dataType: 'json',
	// 			deley: 250,
	// 			data: function (params) {
	// 				return {
	// 					locationVal: params.term,
	// 					module:module,
	// 					select: select,
	// 					join: join,

	// 				};
	// 			},
	// 			processResults: function (data) {
	// 				return {
	// 					results: $.map(data, function(obj, i){
	// 						return obj
	// 					})
	// 				}
					
	// 			},
	// 			cache: true,
	// 		}
	// });
	// $('.selectMultiplePanel').select2({
	// 	minimumInputLength: 2,
	// 	placeholder: 'Nhập tối thiểu 2 ký tự để tìm kiếm',
	// 		ajax: {
	// 			url: 'ajax/dashboard/get_select2',
	// 			type: 'POST',
	// 			dataType: 'json',
	// 			deley: 250,
	// 			data: function (params) {
	// 				return {
	// 					locationVal: params.term,
	// 					module:module,
	// 					select: select,
	// 					join: join,
	// 					language:lang
	// 				};
	// 			},
	// 			processResults: function (data) {
	// 				return {
	// 					results: $.map(data, function(obj, i){
	// 						return obj
	// 					})
	// 				}
					
	// 			},
	// 			cache: true,
	// 		}
	// });
}

function get_select2_multiple(object,lang){
	let module = object.attr('data-module');
	let select = object.attr('data-select');
	let join = object.attr('data-join');
	
	$('.selectMultiplePanel').select2({
		minimumInputLength: 2,
		placeholder: 'Nhập tối thiểu 2 ký tự để tìm kiếm',
			ajax: {
				url: 'ajax/dashboard/get_select2',
				type: 'POST',
				dataType: 'json',
				deley: 250,
				data: function (params) {
					return {
						locationVal: params.term,
						module:module,
						select: select,
						join: join,
						language:lang
					};
				},
				processResults: function (data) {
					return {
						results: $.map(data, function(obj, i){
							return obj
						})
					}
					
				},
				cache: true,
			}
	});
}

function get_select2_panel(object,lang){
	let module = object.attr('data-module');
	let select = object.attr('data-select');
	let join = object.attr('data-join');
	$('.selectAttribute').select2({
		minimumInputLength: 2,
		placeholder: 'Nhập tối thiểu 2 ký tự để tìm kiếm',
			ajax: {
				url: 'ajax/dashboard/get_select2',
				type: 'POST',
				dataType: 'json',
				deley: 250,
				data: function (params) {
					return {
						locationVal: params.term,
						module:module,
						select: select,
						join: join,

					};
				},
				processResults: function (data) {
					return {
						results: $.map(data, function(obj, i){
							return obj
						})
					}
					
				},
				cache: true,
			}
	});
}


