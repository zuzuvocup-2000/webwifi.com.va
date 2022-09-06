$(document).ready(function(){
	$('#new_system').on('click',function(){
        event.preventDefault();
		$('#insert_form')[0].reset();
        $('#add_data_Modal').modal('hide');
	})

    $(document).on('change', '#type_input', function(){
        let type_input = $('#type_input').val();
        $('#add_data_Modal').find('.va-box').html('');
        if(type_input == 'text' || type_input == 'textarea' || type_input == 'ckeditor'){
            $('#add_data_Modal').find('.va-box').append(text_limit());
        }
    })

    if($('.va-highlight').length){
        $('.va-highlight').parent().siblings($('input')).addClass('va-count');
    }


    $(document).on('keyup', '.va-count', function(){
        let _this = $(this);
        let _start = _this.siblings().find($('.va-highlight')).attr('data-start');
        let _end = _this.siblings().find($('.va-highlight')).attr('data-end');
        let metaTitle = _this.val();
        let totalCharacter = metaTitle.length;
        if(totalCharacter > _end || totalCharacter < _start){
            _this.addClass('input-error');
        }else{
            _this.removeClass('input-error');
        }
    });

    $(document).on('keyup','.va-count', function(){
        let _this = $(this);
        let _start = _this.siblings().find($('.va-highlight')).attr('data-start');
        let _end = _this.siblings().find($('.va-highlight')).attr('data-end');
        let totalCharacter = _this.val().length;

        // console.log(totalCharacter);
        // console.log(_this);
        _this.siblings().find($('.titleCount')).text(totalCharacter);
        if(totalCharacter > _end){
            _this.addClass('input-error');
        }else{
            _this.removeClass('input-error');
        }
        $('.g-title').text(_this.val());
    });

	$('#insert_form').on("submit", function(event) {
        event.preventDefault();
        let select_catalogue = $('#select-catalogue').val();
        let name_system = $('#name_system').val();
        let keyword = $('#keyword').val();
        let attention = $('#attention').val();
        let type_input = $('#type_input').val();
        let title_link = $('#title_link').val();
        let link_canonical = $('#link_canonical').val();
		let _this = $(this);
        let start_text = '';
        let end_text = '';
        if(type_input == 'text' || type_input == 'textarea' || type_input == 'ckeditor'){
            start_text = $('#start_text').val();
            end_text = $('#end_text').val();
        }
        if (_this.find($('#select-catalogue')).val() == "" || _this.find($('#select-catalogue')).val() == 0) {
            alert("Bạn cần phải chọn danh mục cho Cấu hình!");
        } else if ($('#name_system').val() == '') {
            alert("Bạn cần phải nhập tên cho Cấu hình!");
        } else if ($('#name_system_database').val() == '') {
            alert("Bạn cần phải nhập từ khóa cho Cấu hình!");
        } else if ($('#type_input').val() == '') {
            alert("Bạn cần phải chọn kiểu dữ liệu của cấu hình cần tạo!");
        } else {
            let form_URL = 'ajax/system/create_input';
			
				$.post(form_URL, {
						select_catalogue: select_catalogue, name_system : name_system,keyword : keyword, type_input:type_input,title_link:title_link, link_canonical:link_canonical, attention:attention, start_text:start_text, end_text : end_text
					},
					function(data){
						$('#insert_form')[0].reset();
	                    $('#add_data_Modal').modal('hide');
                        $('#add_data_Modal').find('.va-wrapper').remove();
						let json = JSON.parse(data);
                        // console.log(json);
						let select_catalogue = json.select_catalogue;
						let name_system = json.name_system;
                        let keyword = json.keyword;
                        let attention = json.attention;
                        let title_link = json.title_link;
						let link_canonical = json.link_canonical;
						let type_input = json.type_input;
                        if(json == ''){
                            toastr.options.closeButton = true;
                            toastr.options.preventDuplicates = true;
                            toastr.options.progressBar = false;
                            toastr.error( 'Từ khóa bạn nhập trùng với từ khóa trong cơ sở dữ liệu!','Đã xảy ra lỗi!');
                        }else{
                            toastr.options.closeButton = true;
                            toastr.options.preventDuplicates = true;
                            toastr.options.progressBar = false;
                            toastr.success('Vui lòng tạo cấu hình tiếp theo!','Tạo cấu hình thành công!' );

                            switch (json.type_input) {
                                case 'text':
                                    $('#'+select_catalogue).find($('.ibox-content')).append(render_text(name_system, keyword));
                                    break;
                                case 'textarea':
                                    $('#'+select_catalogue).find($('.ibox-content')).append(render_textarea(name_system, keyword));
                                    break;
                                case 'img':
                                    $('#'+select_catalogue).find($('.ibox-content')).append(render_img(name_system, keyword));
                                    break;
                                case 'files':
                                    $('#'+select_catalogue).find($('.ibox-content')).append(render_file(name_system, keyword));
                                    break;
                                case 'ckeditor':
                                    location.reload();
                                    break;
                                case 'select':
                                    $('#'+select_catalogue).find($('.ibox-content')).append(render_select(name_system, keyword));
                                    break;
                                case 'select2':
                                    location.reload();
                                    break;
                            }
                        }
					});
        }
    });

    $('#create_new_system').on("submit", function(event) {
        event.preventDefault();
        let name_system_catalogue = $('#name_system_catalogue').val();
        let keyword_system_catalogue = $('#keyword_system_catalogue').val();
        let description_system_catalogue = $('#description_system_catalogue').val();
		let _this = $(this);



        if (name_system_catalogue == '') {
            alert("Bạn cần phải nhập tên cho Nhóm Cấu hình!");
        } else if (keyword_system_catalogue == '') {
            alert("Bạn cần phải nhập từ khóa cho Nhóm Cấu hình!");
        } else if (description_system_catalogue == '') {
            alert("Bạn cần phải nhập mô tả cho Nhóm cấu hình!");
        } else {
            let form_URL = 'ajax/system/create_catalogue';
			// _this.html(loading());
			
			// setTimeout(function(){
				$.post(form_URL, {
						name_system_catalogue: name_system_catalogue, keyword_system_catalogue : keyword_system_catalogue,description_system_catalogue : description_system_catalogue
					},
					function(data){
						$('#create_new_system')[0].reset();
	                    $('#add_new_system').modal('hide');
						let json = JSON.parse(data);
						let name_system_catalogue = json.name_system_catalogue;
						let keyword_system_catalogue = json.keyword_system_catalogue;
						let description_system_catalogue = json.description_system_catalogue;
						$('#system-catalogue').append(system_catalogue(name_system_catalogue, description_system_catalogue,keyword_system_catalogue));
						let cut_name = keyword_system_catalogue.split("-");
						$('#type_input').append(option(cut_name[1], name_system_catalogue));
					});
			// }, 500);
        }
    });
	
    $(document).on('click', '.va-btn-select', function(){
        $('.va-none').find('.va-form-box').remove();
        let _this = $(this);
        var va_info = _this.attr('data-select');
        $('#name_select').val(va_info);
    })

    $(document).on('click', '.va-select-add', function(){
        let _this = $(this);
        $('.va-none').append(add_select());
        return false;
    })

    $(document).on('click', '.va-close-add', function(){
        let _this = $(this);
        _this.closest('.va-form-box').remove();
        return false;
    })

    $('#create_select').on("submit", function(event) {
        event.preventDefault();
        let select = {
            'title_item' : dataSelect('title_item'),
            'value_item' : dataSelect('value_item'),
            'name_select' : dataSelect('name_select')
        }
        let form_URL = 'ajax/system/create_select';
        $.post(form_URL, {
            select: select
        },
        function(data){
            location.reload();
        });
    })



})

function dataSelect(string){
    let object = []
    $('.'+string).each(function(){
        object.push($(this).val())
    });
    return object;
}			 

function render_text(name = '', title = '',link_title = '', link = ''){
	let html = '';
	html = html + '<div class="row mb15">';
	    html = html + '<div class="col-lg-12">';
	        html = html + '<div class="form-row">';
	            html = html + '<div class="uk-flex uk-flex-middle uk-flex-space-between">';
	                html = html + '<label class="control-label text-left">';
	                    html = html + '<span>'+name+'</span>';
	                html = html + '</label>';
	            html = html + '</div>';
	            html = html + '<input type="text" name="config['+title+']" value="" class="form-control " placeholder="">';
	        html = html + '</div>';
	    html = html + '</div>';
	html = html + '</div>';
	return html;
}

function render_img(name = '', title = '',link_title = '', link = ''){
	let html = '';
	html = html + '<div class="row mb15">';
        html = html + '<div class="col-lg-12">';
            html = html + '<div class="form-row">';
                html = html + '<div class="uk-flex uk-flex-middle uk-flex-space-between">';
                    html = html + '<label class="control-label text-left">';
                        html = html + '<span>'+name+'</span>';
                    html = html + '</label>';
                html = html + '</div>';
                html = html + '<input type="text" name="config['+title+']" value="" class="form-control" placeholder="" onclick="BrowseServerAlbum(this)">';
            html = html + '</div>';
        html = html + '</div>';
    html = html + '</div>';
    return html;
}

function render_file(name = '', title = '',link_title = '', link = ''){
	let html = '';
	html = html + '<div class="row mb15">';
        html = html + '<div class="col-lg-12">';
            html = html + '<div class="form-row">';
                html = html + '<div class="uk-flex uk-flex-middle uk-flex-space-between">';
                    html = html + '<label class="control-label text-left">';
                        html = html + '<span>'+name+' </span>';
                    html = html + '</label>';
                html = html + '</div>';
                html = html + '<input type="text" name="config['+title+']" value="" class="form-control" placeholder="" onclick="BrowseServerAlbum(this,\' files\')">';
            html = html + '</div>';
        html = html + '</div>';
    html = html + '</div>';
    return html;
}

function render_textarea(name = '', title = '',link_title = '', link = ''){
	let html = '';
	html = html +'<div class="row mb15">';
        html = html +'<div class="col-lg-12">';
            html = html +'<div class="form-row">';
                html = html +'<div class="uk-flex uk-flex-middle uk-flex-space-between">';
                    html = html +'<label class="control-label text-left">';
                        html = html +'<span>'+name+'</span>';
                    html = html +'</label>';
                html = html +'</div>';
                html = html +'<textarea name="config['+title+']" cols="40" rows="10" class="form-control " style="height:108px;" placeholder=""></textarea>';
            html = html +'</div>';
        html = html +'</div>';
    html = html +'</div>';
    return html;
}

function render_select(name = '', title = '',link_title = '', link = ''){
	let html = '';
	html = html + '<div class="row mb15">';
        html = html + '<div class="col-lg-12">';
            html = html + '<div class="form-row">';
                html = html + '<div class="uk-flex uk-flex-middle uk-flex-space-between">';
                    html = html + '<label class="control-label text-left">';
                        html = html + '<span>'+name+'</span>';
                    html = html + '</label>';
                  	html = html + '<a href="" title="">Tạo giá trị select</a>';
                html = html + '</div>';
                html = html + '<select name="config['+title+']" class="form-control" style="width: 100%;">';
                    html = html + '<option value="yes">Có</option>';
                    html = html + '<option value="no" selected="selected">Không</option>';
                html = html + '</select>';
            html = html + '</div>';
        html = html + '</div>';
    html = html + '</div>';
	return html;
}


function system_catalogue(name = '', description = '',id =''){
	let html = '';
	html = html +'<div class="row" id="'+id+'">';
        html = html +'<div class="col-lg-4">';
            html = html +'<div class="panel-head">';
                html = html +'<h2 class="panel-title">'+name+'</h2>';
                html = html +'<div class="panel-description mb20">';
                    html = html +''+description+'';
                html = html +'</div>';
                html = html +'<button type="button" name="add" data-toggle="modal" data-target="#add_data_Modal" class="btn btn-danger">Thêm cấu hình</button>';
            html = html +'</div>';
        html = html +'</div>';
        html = html +'<div class="col-lg-8">';
            html = html +'<div class="ibox m0">';
                html = html +'<div class="ibox-content">';
                    
                html = html+ '</div>';
            html = html+ '</div>';

        html = html+ '</div>';
    html = html+ '</div>';
	return html;
}

function add_select(){
	let html = '';
	html = html +'<div class="va-form-box">';
        html = html +'<div class="uk-flex uk-flex-middle">';
           html = html +' <div class="va-width-flex mr10">';
                html = html +'<label>Giá trị in ra màn hình</label>  ';
                html = html +'<input type="text" name="title_item" autocomplete="off" class="title_item form-control"  />     ';
            html = html +'</div>';
            html = html +'<div class="va-width-flex mr10">';
                html = html +'<label>Giá trị trong database</label>  ';
                html = html +'<input type="text" name="value_item" class="form-control value_item"   placeholder="">';
            html = html +'</div>';
           html = html +' <div class="va-width-auto">';
                html = html +'<a href="" class="va-close-add ">Xóa bỏ</a>';
        html = html +'</div>';
    html = html +'</div>';
    html = html +'<br /> ';
	return html;
}

function text_limit(){
    let html = '';
    html =html + '<div class=" va-wrapper">'
    html = html + '<br/>';
    html = html + '<label>Giới hạn text trong khoảng từ: </label>  ';
    html = html + '<div class="uk-flex uk-flex-middle">';
        html = html + '<div class="va-limit">';
            html = html + '<input type="number" name="config[start_text]" id="start_text" class="form-control" placeholder="">';
        html = html + '</div>';
        html = html + '<label class="mr5 ml5">Đến</label>  ';
        html = html + '<div class="va-limit">';
            html = html + '<input type="number" name="config[end_text]" id="end_text" class="form-control" placeholder="">';
        html = html + '</div>';
    html = html + '</div>';
    html = html + '</div>';
    return html;
}