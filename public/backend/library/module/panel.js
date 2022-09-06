$(document).ready(function(){
	$(document).on('change','.select2_panel', function(){
		let _this = $(this);
		let val = _this.val()
		let explode = val.split('_');
		$('.select_type_data').html('');
		if(explode[1] == 'catalogue'){
			let html = render_html();
			$('.select_type_data').html(html)
		}
	});

  $(document).on('change','.checkbox-panel-default', function(){
    let _this = $(this);
    let val = _this.val();
    let val_select = $('.selectMultiplePanel').val()
    let language = _this.attr('data-language');
    let module = $('.select2_panel').val()
    let form_URL = 'ajax/dashboard/set_title_canonical';
    if(val_select.length != 0){
      if(this.checked) {
        $.post(form_URL, {
          module : module,language:language,id:val_select[0]
        },
        function(data){
          let json = JSON.parse(data);
          $('.title').val(json.title)
          $('.url-panel').val(json.canonical)
          $('.url-panel').attr('readonly','')
          $('.title').attr('readonly','')
        }); 
      }else{
        $('.title').val('')
        $('.url-panel').val('')
        $('.url-panel').removeAttr('readonly')
        $('.title').removeAttr('readonly')
      }
    }else{
      $('.checkbox-panel-default').prop('checked',false)
      toastr.error('Bạn phải chọn ít nhất 1 đối tượng phù hợp!','Xảy ra lỗi!');
    }
  });

  $(document).on('change','.selectMultiplePanel', function(){
    let _this = $(this);
    let val = _this.val();
    console.log(val);
    let language = $('.checkbox-panel-default').attr('data-language');
    let module = $('.select2_panel').val()
    let form_URL = 'ajax/dashboard/set_title_canonical';
    if(val.length != 0){
      if($('.checkbox-panel-default').is(':checked')) {
        $.post(form_URL, {
          module : module,language:language,id:val[0]
        },
        function(data){
          let json = JSON.parse(data);
          $('.title').val(json.title)
          $('.url-panel').val(json.canonical)
          $('.url-panel').attr('readonly','')
          $('.title').attr('readonly','')
        }); 
      }
    }else{
      $('.title').val('')
      $('.url-panel').val('')
      $('.url-panel').removeAttr('readonly')
      $('.title').removeAttr('readonly')
      $('.checkbox-panel-default').prop('checked',false)
      toastr.warning('Không có đối tượng phù hợp, bạn sẽ trở về mặc định!','Xảy ra lỗi!');
    }
  });

	function render_html(){
		let html = '';
        html = html + '<div class="col-lg-12 mb15">';
            html = html + '<div class="form-row">';
                html = html + '<label class="control-label text-left">';
                    html = html + '<span>Chọn kiểu lấy dữ liệu</span>';
                      html = html + '<span class="text-danger">(Kiểu dự liệu mặc định là lấy các danh mục đã chọn.)</span>';
                html = html + '</label>';
                html = html + '<div>';
                  html = html + ' <div class="i-checks clearfix">';
                       html = html + ' <label class="uk-flex uk-flex-middle">';
                            html = html + '<input style="margin-top:0;margin-right:10px" name="select_type[]" type="checkbox" value="only_post">';
                           html = html + ' <span>Lấy bài viết</span>';
                       html = html + ' </label>';
                   html = html + ' </div>';
                  html = html + '  <div class="i-checks clearfix">';
                       html = html + ' <label class="uk-flex uk-flex-middle">';
                            html = html + '<input style="margin-top:0;margin-right:10px" name="select_type[]" type="checkbox" value="only_cat">';
                          html = html + '  <span>Lấy danh mục (cả danh mục con)</span>';
                      html = html + '  </label>';
                   html = html + ' </div>';
               html = html + ' </div>';
            html = html + '</div>   ';
        html = html + '</div>   ';
        return html;
	}
});