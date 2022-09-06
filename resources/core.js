$(document).on('click','.contact_email_va', function(){
	let _this = $(this)
	let email = $(".email_contact_va").val();
 	if (IsEmail(email) == false) {
		toastr.error('Định dạng Email không hợp lệ!','Xin vui lòng thử lại!');
    } else {
    	let form_URL = 'ajax/frontend/action/contact_email';
		$.post(form_URL, {
			email : email
		},
		function(data){
			if(data.trim() == 'success'){
				toastr.success('Thành công','Bạn đã đăng ký nhận thông báo thành công!');
			}else{
				toastr.error('Có lỗi xảy ra!','Xin vui lòng thử lại!');
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