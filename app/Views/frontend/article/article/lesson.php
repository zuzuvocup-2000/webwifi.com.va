<link href="public/frontend/resources/plugins/dropzone-5.7.0/dist/dropzone.css" rel="stylesheet" />
<script src="public/frontend/resources/plugins/dropzone-5.7.0/dist/min/dropzone.min.js"></script>

<section class="lesson-panel pt50 pb50">
	<div class="main-lesson ">
		<div class="uk-container uk-container-center">
			<div class="uk-grid uk-grid-large uk-clearfix">
				<div class="uk-width-large-3-4">
					<div class="small-title"><?php echo $language == 'vi' ? 'Tuyển dụng' : 'Recruitment' ?></div>
					<h1 class="main-heading-va">
						<?php echo $object['title'] ?>
					</h1>
					<div class="small-line mb30">
						<?php echo $object['description'] ?>
						<?php echo $object['content'] ?>
					</div>
					<button class="apply-now mb20"><?php echo $language == 'vi' ? 'Ứng tuyển ngay' : 'Apply now' ?> <i class="fa fa-arrow-right text-white ml15" aria-hidden="true"></i></button>
					<form class="apply-now-form uk-width-large-3-4 uk-hidden" method="post">
						<div class="title-form-apply mb20"><?php echo $language == 'vi' ? 'VUI LÒNG ĐIỀN ĐẦY ĐỦ THÔNG TIN BÊN DƯỚI (* : BẮT BUỘC)' : 'PLEASE COMPLETE THE INFORMATION BELOW (* : REQUIRED)' ?> </div>
						<div class="form-row mb15">
							<label>Vị trí ứng tuyển <span class="text-danger">(*)</span></label>
							<input type="text" name="type" class="form-control va-type-contact">
						</div>
						<div class="form-row mb15">
							<label>Họ tên <span class="text-danger">(*)</span></label>
							<input type="text" name="fullname" class="form-control va-fullname-contact">
						</div>
						<div class="form-row mb15">
							<label>Địa chỉ <span class="text-danger">(*)</span></label>
							<input type="text" name="address" class="form-control va-address-contact">
						</div>
						<div class="form-row mb15">
							<label>Email <span class="text-danger">(*)</span></label>
							<input type="text" name="email" class="form-control va-email-contact">
						</div>
						<div class="form-row mb15">
							<label>Điện thoại <span class="text-danger">(*)</span></label>
							<input type="text"  name="phone" class="form-control va-phone-contact">
						</div>
						<div class="form-row mb15">
							<label>Nội dung <span class="text-danger">(*)</span></label>
							<textarea  cols="30" name="message" rows="5" class="form-control va-message-contact"></textarea>
						</div>
						<div class="form-row mb15">
							<label>File đính kèm 1 <span class="text-danger">(rar,zip,doc,docx,pdf)</span></label>
	                        <div class="dropzone" id="demouploadfile1">
	                            <div class=" needsclick dz-clickable" id="demo-upload">
	                                <div class="dz-message needsclick">
	                                    <button type="button" class="dz-button">Thả tệp vào đây hoặc nhấp vào để tải lên.</button><br>
	                                </div>
	                            </div>
	                            <input type="hidden" name="file1" class="input-file va-file1-contact">
	                        </div>
						</div>
						<div class="form-row mb15">
							<label>File đính kèm 2 <span class="text-danger">(rar,zip,doc,docx,pdf)</span></label>
	                        <div class="dropzone" id="demouploadfile2">
	                            <div class=" needsclick dz-clickable" id="demo-upload">
	                                <div class="dz-message needsclick">
	                                    <button type="button" class="dz-button">Thả tệp vào đây hoặc nhấp vào để tải lên.</button><br>
	                                </div>
	                            </div>
	                            <input type="hidden" name="file2" class="input-file va-file2-contact">
	                        </div>
						</div>
						<button class="submit-recruitment"><?php echo $language == 'vi' ? 'Gửi' : 'Send' ?></button>
					</form>
				</div>
				<div class="uk-width-large-1-4">
   					<div class="small-title"><?php echo $language == 'vi' ? 'Tuyển dụng khác' : 'Other Recruitment' ?></div>
					<?php 
                        if(isset($articleRelate) && is_array($articleRelate) && count($articleRelate)){
                        foreach ($articleRelate as $key => $value) { 
                    ?>
                    <?php $info = json_decode($value['info'],true); ?>

                        <div class="va-line pt20 pb20">
                            <div class="recruitment-title"><a href="<?php echo $value['canonical'] ?>" title="<?php echo $value['title'] ?>"> <?php echo $value['title'] ?></a></div>
                            <div class="text-over"><?php echo isset($info['address']) ? $info['address'] : '' ?></div>
                        </div>
                    <?php }} ?>
				</div>
			</div>
		</div>
	</div>
</section>

<style>
	.small-title{
		font-size: 24px;
	}

	.main-heading-va{
		font-size: 30px;
	}

	.recruitment-title{
		font-size: 16px;
	}

	.text-over{
		opacity: 0.7;
	}

	.va-line:not(:last-child){
		border-bottom: 1px solid #ccc;
	}

	.apply-now{
		-webkit-box-align: center;
	    -ms-flex-align: center;
	    display: -webkit-inline-box;
	    display: inline-flex;
	    align-items: center;
	    margin-top: 30px;
	    background: #0090d4;
	    border: 0;
	    outline: 0;
	    padding: 10px 30px;
	    color: #fff;
	    text-transform: uppercase;
	}

	.form-control{
		background: #fff;
	}

	.text-danger{
		color: red;
	}

	.submit-recruitment{
		height: 40px;
	    width: 100%;
	    max-width: 180px;
	    display: -webkit-inline-box;
	    display: -ms-inline-flexbox;
	    display: inline-flex;
	    -webkit-box-pack: center;
	    -ms-flex-pack: center;
	    justify-content: center;
	    -webkit-box-align: center;
	    -ms-flex-align: center;
	    align-items: center;
	    border-radius: 0;
	    border: 0;
	    background: #b96e2b;
	    color: #fff;
    	text-transform: uppercase;
	}
</style>

<script>
	$(document).on('click','.apply-now', function(){

		$('.apply-now-form').toggleClass('uk-hidden')
	})
	$(document).on('submit','.apply-now-form', function(){
		let _this = $(this)
		let fullname = $('.va-fullname-contact').val()
		let email = $('.va-email-contact').val()
		let phone = $('.va-phone-contact').val()
		let type = $('.va-type-contact').val()
		let file1 = $('.va-file1-contact').val()
		let file2 = $('.va-file2-contact').val()
		let address = $('.va-address-contact').val()
		let message = $('.va-message-contact').val()
		let check = 0;
		if (fullname.length == 0) {
    		toastr.error('Họ và tên không được để trống!','Xin vui lòng thử lại!');
        } else if(IsEmail(email) == false) {
    		toastr.error('Định dạng Email không hợp lệ!','Xin vui lòng thử lại!');
        }else if(phone.length == 0) {
    		toastr.error('Số điện thoại không được để trống!','Xin vui lòng thử lại!');
        }else if(address.length == 0) {
    		toastr.error('Địa chỉ không được để trống!','Xin vui lòng thử lại!');
        } else if(type.length == 0){
    		toastr.error('Vị trí tuyển dụng không được để trống!','Xin vui lòng thử lại!');
        }else if(message.length < 10){
    		toastr.error('Nội dung cần gửi tối thiểu 10 kí tự!','Xin vui lòng thử lại!');
        }else{
        	let form_URL = 'ajax/frontend/action/contact_full_recruitment';
			$.post(form_URL, {
				email : email,fullname : fullname,phone : phone,message : message,type : type,address : address,file1 : file1,file2 : file2
			},
			function(data){
				if(data.trim() == 'success'){
					toastr.success('Thành công','Bạn đã gửi yêu cầu thành công, chúng tôi sẽ liên hệ với bạn sớm nhất!');
				}else{
					toastr.error('An error occurred!','Xin vui lòng thử lại!');
				}
			});
        }
		return false;
	})

	function IsEmail(email) {
        var regex = /^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
        if (!regex.test(email)) {
            return false;
        } else {
            return true;
        }
    }
</script>

<?php
    $ds          = DIRECTORY_SEPARATOR;
    $APPPATH = substr(APPPATH, 0 ,-5);
    $storeFolder_2 = 'file_member';
    $targetFile_2 =  $storeFolder_2.$ds.slug(date('Y-m-d'), strtotime(gmdate('Y-m-d H:i:s', time() + 7*3600))).$ds;
 ?>
<script>

    $(document).ready(function(){
        Dropzone.autoDiscover = false;
        Dropzone.options.demouploadfile1 = {
            // acceptedFiles:'.7z,.aiff,.asf,.avi,.bmp,.csv,.doc,.docx,.fla,.flv,.gif,.gz,.gzip,.jpeg,.jpg,.mid,.mov,.mp3,.mp4,.mpc,.mpeg,.mpg,.ods,.odt,.pdf,.png,.ppt,.pptx,.pxd,.qt,.ram,.rar,.rm,.rmi,.rmvb,.rtf,.sdc,.sitd,.swf,.sxc,.sxw,.tar,.tgz,.tif,.tiff,.txt,.vsd,.wav,.wma,.wmv,.xls,.xlsx,.zip',
            acceptedFiles:'.doc,.docx,.pdf,.rar,.zip',
            maxFiles : 1
        };
        Dropzone.options.demouploadfile2 = {
            // acceptedFiles:'.7z,.aiff,.asf,.avi,.bmp,.csv,.doc,.docx,.fla,.flv,.gif,.gz,.gzip,.jpeg,.jpg,.mid,.mov,.mp3,.mp4,.mpc,.mpeg,.mpg,.ods,.odt,.pdf,.png,.ppt,.pptx,.pxd,.qt,.ram,.rar,.rm,.rmi,.rmvb,.rtf,.sdc,.sitd,.swf,.sxc,.sxw,.tar,.tgz,.tif,.tiff,.txt,.vsd,.wav,.wma,.wmv,.xls,.xlsx,.zip',
            acceptedFiles:'.doc,.docx,.pdf,.rar,.zip',
            maxFiles : 1
        };
        var abc = new Dropzone("#demouploadfile1",{url:"ajax/frontend/upload/file",addRemoveLinks: true});
        abc.on("complete", function(file) {
            $('#demouploadfile1 .dz-success').each(function(){
                let _this = $(this)
                let attr = _this.find('.dz-details .dz-filename span').html()
                if(attr != undefined){
                     $('#demouploadfile1').find('.input-file').val('<?php echo $targetFile_2 ?>'+attr)
                }
            })
        });

        var abc = new Dropzone("#demouploadfile2",{url:"ajax/frontend/upload/file",addRemoveLinks: true});
        abc.on("complete", function(file) {
            $('#demouploadfile2 .dz-success').each(function(){
                let _this = $(this)
                let attr = _this.find('.dz-details .dz-filename span').html()
                if(attr != undefined){
                   	$('#demouploadfile2').find('.input-file').val('<?php echo $targetFile_2 ?>'+attr)
                }
            })

        });
    });

</script>
