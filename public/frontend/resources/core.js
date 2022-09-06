$(document).on('click','.submit-form-contact', function(){
	let _this = $(this)
	let fullname = $('.va-fullname-contact').val()
	let email = $('.va-email-contact').val()
	let phone = $('.va-phone-contact').val()
	let message = $('.va-message-contact').val()
	let check = 0;
	if (fullname.length == 0) {
		toastr.error('Họ và tên không được để trống!','Xin vui lòng thử lại!');
    } else if(IsEmail(email) == false) {
		toastr.error('Định dạng Email không hợp lệ!','Xin vui lòng thử lại!');
    }else if(phone.length == 0) {
		toastr.error('Số điện thoại không hợp lệ!','Xin vui lòng thử lại!');
    } else if(message.length < 10){
		toastr.error('Nội dung cần gửi tối thiểu 10 kí tự!','Xin vui lòng thử lại!');
    }else{
    	let form_URL = 'ajax/frontend/action/contact_full';
		$.post(form_URL, {
			email : email,fullname : fullname,phone : phone,message : message
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